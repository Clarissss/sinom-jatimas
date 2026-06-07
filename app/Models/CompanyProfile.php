<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    protected $fillable = [
        'company_name',
        'about_us',
        'vision',
        'mission',
        'address',
        'email',
        'phone',
        'logo',
        'about_image_1',
        'about_image_2',
        'about_image_3',
    ];

    public function displayName(): string
    {
        return $this->company_name ?? 'PT. Sinom Jati Mas';
    }

    public function imageUrl(?string $path): string
    {
        if (empty($path)) {
            return '';
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return asset('storage/' . ltrim($path, '/'));
    }

    public function aboutImageUrl(string $field, string $fallbackAsset): string
    {
        $path = $this->{$field} ?? null;

        return ! empty($path) ? $this->imageUrl($path) : asset($fallbackAsset);
    }
}
