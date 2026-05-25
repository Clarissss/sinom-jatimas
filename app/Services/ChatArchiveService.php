<?php

namespace App\Services;

use App\Exceptions\ChatEncryptionException;
use App\Models\ChatMessage;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class ChatArchiveService
{
    private ChatEncryptionService $encryption;

    public function __construct(ChatEncryptionService $encryption)
    {
        $this->encryption = $encryption;
    }

    /**
     * Archive a collection of chat messages for a given project/conversation.
     *
     * @param  int  $projectId
     * @param  Collection<int, ChatMessage>  $messages
     * @return string The storage path of the uploaded archive file
     */
    public function archiveMessages(int $projectId, Collection $messages): string
    {
        if ($messages->isEmpty()) {
            throw new RuntimeException('No messages to archive.');
        }

        $disk = $this->disk();
        $dateSuffix = now()->format('Ymd_His');
        $filename = "project_{$projectId}_{$dateSuffix}.jsonl.enc.gz";
        $path = rtrim(config('chat.archive.path_prefix', 'chat-archives'), '/')
            . '/' . $filename;

        // Build JSONL content
        $jsonlLines = $messages->map(function (ChatMessage $message) {
            return $this->messageToJson($message);
        })->implode("\n");

        // Compress with gzip
        $compressed = gzencode($jsonlLines, 9);

        if ($compressed === false) {
            throw new RuntimeException('Gzip compression failed during archive.');
        }

        // Derive archive-specific key and encrypt
        $archiveKey = $this->encryption->deriveArchiveKey($projectId, $dateSuffix);
        $encrypted = $this->encryption->encryptBinary($compressed, $archiveKey);

        // Upload to object storage
        if (! $disk->put($path, $encrypted)) {
            throw new RuntimeException("Failed to upload archive to object storage: {$path}");
        }

        Log::info('Chat archive uploaded', [
            'project_id' => $projectId,
            'path' => $path,
            'message_count' => $messages->count(),
            'size_bytes' => strlen($encrypted),
        ]);

        return $path;
    }

    /**
     * Retrieve and decrypt archived messages from object storage.
     *
     * @param  string  $archivePath
     * @param  int  $projectId
     * @return Collection<int, array>
     */
    public function retrieveArchive(string $archivePath, int $projectId): Collection
    {
        $disk = $this->disk();

        if (! $disk->exists($archivePath)) {
            throw new RuntimeException("Archive not found: {$archivePath}");
        }

        $encrypted = $disk->get($archivePath);

        if ($encrypted === false || $encrypted === '') {
            throw new RuntimeException("Failed to read archive: {$archivePath}");
        }

        // Derive key: we need the date suffix from filename
        $dateSuffix = $this->extractDateSuffixFromFilename($archivePath);
        $archiveKey = $this->encryption->deriveArchiveKey($projectId, $dateSuffix);

        // Decrypt
        $compressed = $this->encryption->decryptBinary($encrypted, $archiveKey);

        // Decompress
        $jsonl = gzdecode($compressed);

        if ($jsonl === false) {
            throw new RuntimeException('Gzip decompression failed for archive.');
        }

        // Parse JSONL
        $lines = collect(explode("\n", trim($jsonl)))
            ->filter(fn (string $line) => $line !== '')
            ->map(function (string $line) {
                $decoded = json_decode($line, true);

                if ($decoded === null && json_last_error() !== JSON_ERROR_NONE) {
                    throw new RuntimeException('Invalid JSON in archive line: ' . json_last_error_msg());
                }

                return $decoded;
            });

        return $lines;
    }

    /**
     * Delete the archive file from object storage.
     */
    public function deleteArchive(string $archivePath): bool
    {
        $disk = $this->disk();

        if ($disk->exists($archivePath)) {
            return $disk->delete($archivePath);
        }

        return true;
    }

    /**
     * Get messages eligible for archiving.
     *
     * @return Collection<int, ChatMessage>
     */
    public function getMessagesToArchive(int $projectId, int $thresholdDays): Collection
    {
        $cutoff = Carbon::now()->subDays($thresholdDays);

        return ChatMessage::where('project_id', $projectId)
            ->whereNull('archived_at')
            ->where('created_at', '<', $cutoff)
            ->orderBy('created_at')
            ->get();
    }

    /**
     * Mark DB records as archived and optionally delete them.
     *
     * @param  Collection<int, ChatMessage>  $messages
     */
    public function markAsArchived(Collection $messages, string $archivePath, bool $deleteAfter = true): void
    {
        $ids = $messages->pluck('id')->toArray();

        if ($deleteAfter) {
            ChatMessage::whereIn('id', $ids)->delete();

            Log::info('Archived messages deleted from database', [
                'count' => count($ids),
                'archive_path' => $archivePath,
            ]);
        } else {
            ChatMessage::whereIn('id', $ids)->update([
                'archived_at' => now(),
                'archive_path' => $archivePath,
            ]);

            Log::info('Archived messages marked in database', [
                'count' => count($ids),
                'archive_path' => $archivePath,
            ]);
        }
    }

    /**
     * Convert a ChatMessage to a JSON string for archive storage.
     *
     * We store the encrypted payload directly to avoid double encryption/decryption.
     */
    private function messageToJson(ChatMessage $message): string
    {
        $raw = $message->getAttributes();

        $data = [
            'id' => $message->id,
            'project_id' => $message->project_id,
            'sender_id' => $message->sender_id,
            'sender_name' => optional($message->sender)->name,
            'content_encrypted' => $raw['content_encrypted'] ?? null,
            'message_plain' => empty($raw['content_encrypted']) && !empty($raw['message']) ? $raw['message'] : null,
            'is_read' => $message->is_read,
            'file_path' => $message->file_path,
            'file_name' => $message->file_name,
            'file_type' => $message->file_type,
            'file_size' => $message->file_size,
            'created_at' => $message->created_at?->toIso8601String(),
            'updated_at' => $message->updated_at?->toIso8601String(),
        ];

        $json = json_encode($data, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);

        return $json;
    }

    /**
     * Get the configured storage disk.
     */
    private function disk(): \Illuminate\Contracts\Filesystem\Filesystem
    {
        return Storage::disk(config('chat.archive.disk', 's3'));
    }

    /**
     * Extract the date suffix from an archive filename.
     *
     * Expected format: project_{id}_YYYYMMDD_HHis.jsonl.enc.gz
     */
    private function extractDateSuffixFromFilename(string $path): string
    {
        $filename = basename($path);

        if (preg_match('/_(\d{8}_\d{6})\.jsonl\.enc\.gz$/', $filename, $matches)) {
            return $matches[1];
        }

        throw new RuntimeException("Cannot extract date suffix from archive filename: {$filename}");
    }
}
