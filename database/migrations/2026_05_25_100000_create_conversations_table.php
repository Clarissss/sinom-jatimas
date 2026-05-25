<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->comment('Client/user who started the conversation');
            $table->foreignId('admin_id')->nullable()->constrained('users')->comment('Assigned admin');
            $table->foreignId('project_id')->nullable()->constrained()->comment('Filled when converted to project');
            $table->string('status')->default('active')->comment('active, closed, converted');
            $table->string('subject')->nullable();
            $table->timestamp('last_message_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'last_message_at']);
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
