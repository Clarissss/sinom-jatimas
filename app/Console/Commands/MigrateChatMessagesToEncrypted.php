<?php

namespace App\Console\Commands;

use App\Models\ChatMessage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class MigrateChatMessagesToEncrypted extends Command
{
    protected $signature = 'chat:migrate-encrypted
                            {--project-id= : Migrate messages for a specific project only}
                            {--chunk=100 : Number of messages to process per chunk}
                            {--dry-run : Show what would be migrated without making changes}';

    protected $description = 'Migrate legacy plain-text chat messages to AES-256-GCM encrypted storage.';

    public function handle(): int
    {
        $chunkSize = (int) $this->option('chunk');
        $dryRun = $this->option('dry-run');
        $specificProjectId = $this->option('project-id');

        $this->info("Migrating legacy chat messages to encrypted storage...");
        $this->info("Chunk size: {$chunkSize}");
        $this->info("Dry run: " . ($dryRun ? 'Yes' : 'No'));

        $query = ChatMessage::whereNull('content_encrypted')
            ->whereNotNull('message');

        if ($specificProjectId) {
            $query->where('project_id', $specificProjectId);
            $this->info("Project filter: {$specificProjectId}");
        }

        $total = $query->count();

        if ($total === 0) {
            $this->info('No legacy messages found to migrate.');
            return self::SUCCESS;
        }

        $this->info("Found {$total} legacy message(s) to migrate.");
        $this->newLine();

        $processed = 0;
        $failed = 0;

        $query->orderBy('id')->chunk($chunkSize, function ($messages) use ($dryRun, &$processed, &$failed) {
            foreach ($messages as $message) {
                try {
                    if (! $dryRun) {
                        // Setting the virtual 'message' attribute triggers the mutator
                        // which writes to content_encrypted via the cast
                        $plainText = $message->getAttributes()['message'];
                        $message->message = $plainText;
                        $message->save();
                    }

                    $processed++;
                    $this->info("Migrated message ID: {$message->id}");
                } catch (Throwable $e) {
                    $failed++;
                    $this->error("Failed message ID {$message->id}: {$e->getMessage()}");

                    Log::error('Chat message migration failed', [
                        'message_id' => $message->id,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        });

        $this->newLine();
        $this->info("Done. Migrated: {$processed}, Failed: {$failed}");

        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }
}
