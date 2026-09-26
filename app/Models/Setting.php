<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
        'description',
    ];

    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set(string $key, mixed $value, string $group = 'general', ?string $description = null): self
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group, 'description' => $description]
        );
    }

    public static function getLogoUrl(): string
    {
        $logo = static::get('site_logo');
        if (!empty($logo)) {
            return str_starts_with($logo, 'http') ? $logo : asset('storage/' . ltrim($logo, '/'));
        }
        return asset('images/logo.png');
    }

    public static function getFaviconUrl(): string
    {
        $favicon = static::get('site_favicon');
        if (!empty($favicon)) {
            return str_starts_with($favicon, 'http') ? $favicon : asset('storage/' . ltrim($favicon, '/'));
        }
        return asset('images/logo.png');
    }
}

