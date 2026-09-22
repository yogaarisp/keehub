<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = fake()->words(3, true);

        return [
            'sku' => str()->upper(fake()->unique()->bothify('SKU-####-???')),
            'name' => ucfirst($name),
            'slug' => str()->slug($name.'-'.fake()->unique()->numberBetween(1, 9999)),
            'category_id' => Category::factory(),
            'brand_id' => Brand::factory(),
            'description' => fake()->paragraph(),
            'price' => fake()->numberBetween(200000, 15000000),
            'cost_price' => fn (array $attributes) => (int) round((int) $attributes['price'] * 0.9),
            'weight_grams' => fake()->numberBetween(200, 5000),
            'dimensions' => null,
            'warranty' => fake()->randomElement(['1 Tahun', '3 Tahun Resmi', '5 Tahun']),
            'is_active' => true,
            'is_featured' => false,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    public function withInventory(int $stock = 10, int $minStock = 2): static
    {
        return $this->afterCreating(fn (Product $product) => Inventory::factory()->create([
            'product_id' => $product->id,
            'current_stock' => $stock,
            'min_stock' => $minStock,
        ]));
    }
}
