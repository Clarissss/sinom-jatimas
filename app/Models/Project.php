<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
    'name',
    'client_id',
    'location',
    'latitude', 
    'longitude', 
    'status',
    'progress_percentage',
    'contract_value',
    'description',
    
];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'progress_percentage' => 'integer',
        'contract_value' => 'decimal:2',
    ];

    // Relasi ke Invoice
    public function invoices(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Menghitung total nominal dari semua invoice (Attribute)
     */
    public function getTotalInvoicedAttribute()
    {
        // Menjumlahkan kolom 'amount' dari semua invoice terkait
        return $this->invoices->sum('amount');
    }

    /**
     * Menghitung sisa pembayaran (Attribute)
     */
    public function getRemainingPaymentAttribute()
    {
        $contractValue = (float) ($this->contract_value ?? 0);
        return $contractValue - (float) $this->total_invoiced;
    }

    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function progressPhotos(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProjectProgress::class);
    }

    public function dailyReports(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DailyReport::class);
    }

    public function chatMessages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function documents(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function scopeActive(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('status', 'in_progress');
    }
}