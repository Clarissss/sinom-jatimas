<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'icon', 'is_active'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($service) {
            $service->slug = Str::slug($service->name);
        });
    }

    public function iconUrl(): ?string
    {
        return $this->icon ? asset('storage/' . $this->icon) : null;
    }

    public function fallbackIconClass(): string
    {
        $slug = $this->slug ?? Str::slug($this->name);

        if (str_contains($slug, 'contractor')) {
            return 'fa-road';
        }
        if (str_contains($slug, 'trading')) {
            return 'fa-house-chimney';
        }
        if (str_contains($slug, 'cut') || str_contains($slug, 'fill')) {
            return 'fa-mountain';
        }

        return 'fa-screwdriver-wrench';
    }
}