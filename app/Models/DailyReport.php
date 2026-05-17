<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
    'client_id',
    'project_id',
    'report_date',
    'activity_description',
    'weather_condition',
    'photo',
    'created_by',
    'is_accepted',
];

protected $casts = [
    'report_date' => 'date',
    'is_accepted' => 'boolean',
];

    /**
     * Get the client that owns this daily report.
     */
    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Get the project that owns this daily report.
     */
    public function project(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user who created this daily report.
     */
    public function creator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}