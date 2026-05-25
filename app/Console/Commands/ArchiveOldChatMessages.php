<?php

namespace App\Console\Commands;

use App\Models\ChatMessage;
use App\Services\ChatArchiveService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class ArchiveOldChatMessages extends Command
{
    protected $signature = 'chat:archive
                            {--project-id= : Archive messages for a specific project only}
                            {--threshold= : Override the default archive threshold in days}
                            {--dry-run : Show what would be archived without making changes}';

    protected $description = 'Archive chat messages older than the configured threshold to object storage (encrypted + compressed JSONL).';

    public function handle(ChatArchiveService $archiveService): int
    {
        $thresholdDays = (int) ($this->option('threshold') ?? config('chat.archive.threshold_days', 90));
        $dryRun = $this->option('dry-run');
        $specificProjectId = $this->option('project-id');

        $this->info("Archive threshold: {$thresholdDays} days");
        $this->info("Dry run: " . ($dryRun ? 'Yes' : 'No'));

        if ($specificProjectId) {
            $this->info("Project filter: {$specificProjectId}");
            $projectIds = [(int) $specificProjectId];
        } else {
            // Find all projects that have old messages
            $projectIds = ChatMessage::whereNull('archived_at')
                ->where('created_at', '<', now()->subDays($thresholdDays))
                ->distinct()
                ->pluck('project_id')
                ->toArray();
        }

        if (empty($projectIds)) {
            $this->info('No messages found to archive.');
            return self::SUCCESS;
        }

        $this->info("Found " . count($projectIds) . " project(s) with messages to archive.");
        $this->newLine();

        $totalArchived = 0;
        $totalFailed = 0;

        foreach ($projectIds as $projectId) {
            $messages = $archiveService->getMessagesToArchive($projectId, $thresholdDays);

            if ($messages->isEmpty()) {
                continue;
            }

            $count = $messages->count();
            $this->info("Project {$projectId}: {$count} message(s) to archive");

            if ($dryRun) {
                $totalArchived += $count;
                continue;
            }

            try {
                $archivePath = $archiveService->archiveMessages($projectId, $messages);

                $deleteAfter = config('chat.archive.delete_after_archive', true);
                $archiveService->markAsArchived($messages, $archivePath, $deleteAfter);

                $totalArchived += $count;
                $this->info("  -> Archived to: {$archivePath}");
            } catch (Throwable $e) {
                $totalFailed += $count;
                $this->error("  -> Failed: {$e->getMessage()}");

                Log::error('Chat archive failed', [
                    'project_id' => $projectId,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        }

        $this->newLine();
        $this->info("Done. Archived: {$totalArchived}, Failed: {$totalFailed}");

        return $totalFailed > 0 ? self::FAILURE : self::SUCCESS;
    }
}
