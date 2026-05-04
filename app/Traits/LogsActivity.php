<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait LogsActivity
{
    public static function bootLogsActivity()
    {
        static::created(function ($model) {
            $model->logActivity('created', null, $model->getAttributes());
        });

        static::updated(function ($model) {
            $model->logActivity('updated', $model->getOriginal(), $model->getAttributes());
        });

        static::deleted(function ($model) {
            $model->logActivity('deleted', $model->getAttributes(), null);
        });
    }

    protected function logActivity(string $action, ?array $oldValues, ?array $newValues): void
    {
        $description = $this->getActivityDescription($action);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => static::class,
            'model_id' => $this->getKey(),
            'description' => $description,
            'old_values' => $oldValues ? $this->filterSensitiveData($oldValues) : null,
            'new_values' => $newValues ? $this->filterSensitiveData($newValues) : null,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    protected function getActivityDescription(string $action): string
    {
        $modelName = class_basename(static::class);
        $identifier = $this->getActivityIdentifier();

        return match($action) {
            'created' => "Membuat {$modelName} baru: {$identifier}",
            'updated' => "Mengupdate {$modelName}: {$identifier}",
            'deleted' => "Menghapus {$modelName}: {$identifier}",
            default => "Melakukan {$action} pada {$modelName}: {$identifier}",
        };
    }

    protected function getActivityIdentifier(): string
    {
        if (isset($this->name)) return $this->name;
        if (isset($this->title)) return $this->title;
        if (isset($this->email)) return $this->email;
        if (isset($this->invoice_number)) return $this->invoice_number;
        return "ID: {$this->getKey()}";
    }

    protected function filterSensitiveData(array $data): array
    {
        $sensitive = ['password', 'remember_token', 'email_verified_at'];
        return collect($data)->except($sensitive)->toArray();
    }
}
