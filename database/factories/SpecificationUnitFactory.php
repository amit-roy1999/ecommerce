<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SpecificationUnit>
 */
class SpecificationUnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->randomElement(['mm', 'inch', 'kg', 'red', 'ghz']);
        return [
            'name' => $name,
            'slug' => str($name)->slug(),
        ];
    }
}
