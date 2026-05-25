<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chat_messages', function (Blueprint $table) {
            // Add encrypted content column
            $table->longText('content_encrypted')->nullable()->after('message');
            
            // Add archive tracking columns
            $table->timestamp('archived_at')->nullable()->after('content_encrypted');
            $table->string('archive_path')->nullable()->after('archived_at');
        });
    }

    public function down(): void
    {
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->dropColumn(['content_encrypted', 'archived_at', 'archive_path']);
        });
    }
};
