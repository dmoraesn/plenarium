<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = ['group', 'key', 'value', 'description'];

    protected $casts = [
        'value' => 'array',
    ];

    public static function get(string $key, $default = null)
    {
        return Cache::rememberForever("settings.{$key}", function () use ($key, $default) {
            $record = static::query()->where('key', $key)->first();
            return $record ? $record->value : $default;
        });
    }

    public static function set(string $key, $value): void
    {
        [$group] = static::splitKey($key);
        static::updateOrCreate(
            ['key' => $key],
            ['group' => $group, 'value' => $value]
        );
        Cache::forget("settings.{$key}");
    }

    protected static function splitKey(string $key): array
    {
        if (str_contains($key, '.')) {
            $parts = explode('.', $key, 2);
            return [$parts[0], $parts[1]];
        }
        return ['geral', $key];
    }
}
