<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'imageable_id' => rand(1,100),
            'imageable_type' => null,
            'url' => fake()->imageUrl(),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }

    public function modelTypeAndId(string $modelType)
    {
        return $this->state(function (array $attributes) use ($modelType) {
                return [
                    'imageable_type' => $modelType,
                ];
        });
    }
}
