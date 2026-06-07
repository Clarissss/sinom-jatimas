<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'project_id',
        'type',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'uploaded_by',
    ];

    /**
     * Get the project that owns this document.
     */
    public function project(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user who uploaded this document.
     */
    public function uploader(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getTypeLabelAttribute(): string
    {
        $labels = [
            'contract' => 'Kontrak Kerja',
            'technical_drawing' => 'Gambar Teknis',
            'bast' => 'BAST',
            'material_report' => 'Laporan Material',
            'field_map' => 'Peta Lapangan',
            'other' => 'Lainnya',
        ];

        return $labels[$this->type] ?? 'Lainnya';
    }
    
}
