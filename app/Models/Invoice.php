<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'project_id',
        'invoice_number',
        'amount',
        'termin_percentage',
        'status',
        'due_date',
        'pdf_path',
        'created_by',
        'sent_at',
        'paid_at',
    ];

    protected $casts = [
        'due_date' => 'date',
        'sent_at' => 'datetime',
        'paid_at' => 'datetime',
        'amount' => 'decimal:2',
        'termin_percentage' => 'integer',
    ];

    /**
     * Get the project that owns this invoice.
     */
    public function project(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user who created this invoice.
     */
    public function creator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope to get only draft invoices.
     */
    public function scopeDraft(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope to get only sent invoices.
     */
    public function scopeSent(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('status', 'sent');
    }

    /**
     * Scope to get only overdue invoices.
     */
    public function scopeOverdue(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('status', 'overdue');
    }

    /**
     * Scope to get only paid invoices.
     */
    public function scopePaid(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('status', 'paid');
    }

    public function getStatusLabelAttribute(): string
    {
        $labels = [
            'draft' => 'Draft',
            'sent' => 'Terkirim',
            'overdue' => 'Jatuh Tempo',
            'paid' => 'Lunas',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute(): string
    {
        $colors = [
            'draft' => 'gray',
            'sent' => 'blue',
            'overdue' => 'red',
            'paid' => 'green',
        ];

        return $colors[$this->status] ?? 'gray';
    }
}
