<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    public $incrementing = false;

    protected $primaryKey = 'key';

    protected $keyType = 'string';

    protected $fillable = ['key', 'value'];

    public static function get(string $key, ?string $default = null): ?string
    {
        return static::query()->find($key)?->value ?? $default;
    }

    public static function put(string $key, ?string $value): void
    {
        static::query()->updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public static function storedFileUrl(string $key): ?string
    {
        $path = static::get($key);
        if ($path && Storage::disk('public')->exists($path)) {
            return '/storage/'.ltrim($path, '/');
        }

        return null;
    }

    public static function logoUrl(): string
    {
        return static::storedFileUrl('store_logo') ?? '/logo-96.png';
    }

    public static function faviconUrl(): string
    {
        return static::storedFileUrl('store_favicon') ?? '/favicon-32.png';
    }

    public static function heroBackgroundUrl(): ?string
    {
        return static::storedFileUrl('hero_background');
    }

    public function items(): HasMany
    {
        return $this->hasMany(Setting::class, 'key', 'key');
    }
}
