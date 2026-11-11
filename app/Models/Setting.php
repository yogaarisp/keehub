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

    /**
     * Resolve Tailwind layout classes for the storefront hero background.
     *
     * @return array{fitClass: string, positionClass: string, paddingClass: string, overlayClass: string}
     */
    public static function heroDisplayConfig(): array
    {
        $fit = static::get('hero_background_fit', 'cover') ?: 'cover';
        $position = static::get('hero_background_position', 'center') ?: 'center';
        $height = static::get('hero_background_height', 'compact') ?: 'compact';

        $fitMap = [
            'cover' => 'object-cover',
            'contain' => 'object-contain',
            'fill' => 'object-fill',
        ];

        $positionMap = [
            'center' => $fit === 'cover' ? 'object-[72%_70%] md:object-center' : 'object-center',
            'top' => 'object-top',
            'bottom' => 'object-bottom',
            'left' => 'object-left',
            'right' => 'object-center md:object-right',
        ];

        $heightMap = [
            'compact' => 'py-12 md:py-16',
            'medium' => 'py-14 md:py-24',
            'tall' => 'py-16 md:py-32',
        ];

        $overlayClass = $fit === 'contain'
            ? 'bg-gradient-to-r from-slate-950/95 via-slate-950/65 to-slate-950/25'
            : 'bg-gradient-to-r from-slate-950/90 via-slate-950/75 to-slate-950/60';

        return [
            'fitClass' => $fitMap[$fit] ?? $fitMap['cover'],
            'positionClass' => $positionMap[$position] ?? $positionMap['center'],
            'paddingClass' => $heightMap[$height] ?? $heightMap['compact'],
            'overlayClass' => $overlayClass,
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(Setting::class, 'key', 'key');
    }
}
