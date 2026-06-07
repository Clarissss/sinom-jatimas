<?php

namespace App\Models;

use App\Casts\EncryptedMessageCast;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'project_id',
        'conversation_id',
        'sender_id',
        'message',
        'content_encrypted',
        'is_read',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'document_type',
        'archived_at',
        'archive_path',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'archived_at' => 'datetime',
        'content_encrypted' => EncryptedMessageCast::class,
    ];

    /**
     * Get the project that owns this chat message (if project-based chat).
     */
    public function project(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the conversation that owns this chat message (if general chat).
     */
    public function conversation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * Get the sender of this chat message.
     */
    public function sender(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Accessor for backward compatibility with "message" attribute.
     * Maps to the encrypted content column (auto-decrypted by cast).
     * Falls back to legacy 'message' column for unmigrated data.
     */
    public function getMessageAttribute(): ?string
    {
        $encrypted = $this->getAttributes()['content_encrypted'] ?? null;

        if (! empty($encrypted)) {
            return $this->content_encrypted;
        }

        return $this->getAttributes()['message'] ?? null;
    }

    /**
     * Mutator for backward compatibility with "message" attribute.
     * Maps to the encrypted content column (auto-encrypted by cast).
     */
    public function setMessageAttribute(?string $value): void
    {
        $this->content_encrypted = $value;
    }

    /**
     * Scope to exclude archived messages from normal queries.
     */
    public function scopeNotArchived($query)
    {
        return $query->whereNull('archived_at');
    }

    /**
     * Scope to include only archived messages.
     */
    public function scopeArchived($query)
    {
        return $query->whereNotNull('archived_at');
    }

    /**
     * Check if this message belongs to a general conversation (not project).
     */
    public function isGeneralChat(): bool
    {
        return $this->conversation_id !== null;
    }

    /**
     * Check if this message has been moved to archive storage.
     */
    public function isArchived(): bool
    {
        return $this->archived_at !== null;
    }
}
