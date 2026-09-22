<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'slug',
        'category_id',
        'brand_id',
        'description',
        'price',
        'cost_price',
        'weight_grams',
        'dimensions',
        'warranty',
        'is_active',
        'is_featured',
        'meta_title',
        'meta_description',
        'keywords',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'price' => 'integer',
            'cost_price' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderByDesc('is_primary')->orderBy('sort_order');
    }

    public function specs(): HasMany
    {
        return $this->hasMany(ProductSpec::class)->orderBy('sort_order');
    }

    public function inventory(): HasOne
    {
        return $this->hasOne(Inventory::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function primaryImage(): ?string
    {
        return $this->images->first()?->path;
    }

    public function stockStatus(): string
    {
        $stock = $this->inventory?->current_stock ?? 0;
        if ($stock <= 0) {
            return 'out_of_stock';
        }

        return $stock <= ($this->inventory->min_stock ?? 0) ? 'low_stock' : 'in_stock';
    }

    public function spec(string $key): ?ProductSpec
    {
        return $this->specs->firstWhere('key', $key);
    }

    public function specValue(string $key): ?string
    {
        return $this->spec($key)?->value;
    }

    public function specNumeric(string $key): ?float
    {
        return $this->spec($key)?->value_numeric;
    }
}
