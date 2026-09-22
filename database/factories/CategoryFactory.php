<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = fake()->unique()->randomElement(['CPU', 'Motherboard', 'GPU', 'RAM', 'SSD', 'HDD', 'PSU', 'Casing', 'CPU Cooler', 'Monitor', 'Keyboard', 'Mouse', 'Networking']);

        return [
            'name' => $name,
            'slug' => str()->slug($name),
            'icon' => 'cpu',
            'description' => fake()->sentence(),
            'sort_order' => fake()->numberBetween(0, 20),
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
