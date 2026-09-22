<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition(): array
    {
        $name = fake()->unique()->randomElement(['AMD', 'Intel', 'ASUS', 'MSI', 'Gigabyte', 'Corsair', 'Kingston', 'Samsung', 'Lian Li', 'Cooler Master', 'DeepCool', 'NVIDIA']);

        return [
            'name' => $name,
            'slug' => str()->slug($name),
            'logo' => null,
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
