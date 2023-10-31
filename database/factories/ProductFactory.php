<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->address();
        return [
            'category_id' => rand(1,100),
            'brand_id' => rand(1,10),
            'name' => $name,
            'slug' => str($name)->slug(),
            'image' => fake()->imageUrl(),
            'description' => fake()->paragraph(),
            'price' => rand(10, 10000),
            'avalebel_discount_in_percentage' => rand(1, 100),
        ];
    }
}
