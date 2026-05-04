<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'description',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * Get the user who performed this activity.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subject model of this activity.
     */
    public function subject(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo('model', 'model_type', 'model_id');
    }

    /**
     * Scope to get recent activity logs.
     */
    public function scopeRecent(\Illuminate\Database\Eloquent\Builder $query, int $limit = 50): \Illuminate\Database\Eloquent\Builder
    {
        return $query->latest()->limit($limit);
    }

    /**
     * Scope to filter by model type and optionally model id.
     */
    public function scopeForModel(\Illuminate\Database\Eloquent\Builder $query, string $modelType, ?int $modelId = null): \Illuminate\Database\Eloquent\Builder
    {
        $query->where('model_type', $modelType);
        if ($modelId) {
            $query->where('model_id', $modelId);
        }
        return $query;
    }

    /**
     * Scope to filter by user.
     */
    public function scopeForUser(\Illuminate\Database\Eloquent\Builder $query, int $userId): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to get today's activity logs.
     */
    public function scopeToday(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->whereDate('created_at', today());
    }

    public function getActionColorAttribute(): string
    {
        return match($this->action) {
            'created' => 'green',
            'updated' => 'yellow',
            'deleted' => 'red',
            'login' => 'blue',
            'logout' => 'gray',
            'downloaded' => 'purple',
            'uploaded' => 'indigo',
            'sent' => 'pink',
            default => 'gray',
        };
    }

    public function getActionIconAttribute(): string
    {
        return match($this->action) {
            'created' => 'plus',
            'updated' => 'pencil',
            'deleted' => 'trash',
            'login' => 'login',
            'logout' => 'logout',
            'downloaded' => 'download',
            'uploaded' => 'upload',
            'sent' => 'paper-airplane',
            default => 'information',
        };
    }
}
