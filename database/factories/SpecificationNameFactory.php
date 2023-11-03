<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SpecificationName>
 */
class SpecificationNameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->randomElement(['hight', 'width', 'weight', 'color', 'clock speed']);
        return [
            'name' => $name,
            'slug' => str($name)->slug(),
        ];
    }
}
