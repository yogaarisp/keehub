<?php

namespace Database\Factories;

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Inventory>
 */
class InventoryFactory extends Factory
{
    protected $model = Inventory::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'current_stock' => fake()->numberBetween(0, 50),
            'min_stock' => fake()->numberBetween(1, 5),
        ];
    }

    public function inStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'current_stock' => fake()->numberBetween(10, 50),
        ]);
    }

    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'current_stock' => 0,
        ]);
    }

    public function lowStock(): static
    {
        return $this->state(function (array $attributes) {
            $min = fake()->numberBetween(5, 10);

            return [
                'current_stock' => fake()->numberBetween(1, $min),
                'min_stock' => $min,
            ];
        });
    }
}
