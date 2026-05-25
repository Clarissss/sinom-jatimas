<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Chat Encryption
    |--------------------------------------------------------------------------
    |
    | Configuration for application-level AES-256-GCM encryption of chat
    | message contents. The master key should be a base64-encoded or raw
    | string of at least 32 bytes.
    |
    */

    'encryption' => [
        'master_key' => env('CHAT_ENCRYPTION_MASTER_KEY'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Chat Archive
    |--------------------------------------------------------------------------
    |
    | Old messages are archived to object storage after a configurable number
    | of days. Archive files are stored as gzip-compressed, AES-256-GCM
    | encrypted line-delimited JSON (JSONL).
    |
    */

    'archive' => [
        // Number of days after which messages are eligible for archiving
        'threshold_days' => (int) env('CHAT_ARCHIVE_THRESHOLD_DAYS', 90),

        // Filesystem disk to use for archive storage (s3, r2, minio, etc.)
        'disk' => env('CHAT_ARCHIVE_DISK', 's3'),

        // Directory prefix within the bucket
        'path_prefix' => env('CHAT_ARCHIVE_PATH_PREFIX', 'chat-archives'),

        // Number of messages to process per chunk during archiving
        'chunk_size' => (int) env('CHAT_ARCHIVE_CHUNK_SIZE', 500),

        // Whether to delete local DB records after successful archive upload
        'delete_after_archive' => (bool) env('CHAT_ARCHIVE_DELETE_AFTER', true),
    ],

];
