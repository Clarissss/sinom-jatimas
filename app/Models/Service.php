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
}