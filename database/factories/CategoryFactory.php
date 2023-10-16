<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'parent_id' => null,
            'name' => 'whatever',
            'slug' => 'whatever',
            'created_at' => now(),
            'updated_at' => now()
        ];
    }

    public function parentId($parentId)
    {
        return $this->state(function (array $attributes) use ($parentId) {
            if ($parentId) {
                $name = 'ChildCategory' . rand(11111, 99999);
                return [
                    'parent_id' => rand($parentId[0], $parentId[1]),
                    'name' => $name,
                    'slug' => str($name)->slug(),
                ];
            } else {
                $name = 'ParentCategory' . rand(11111, 99999);
                return [
                    'name' => $name,
                    'slug' => str($name)->slug(),
                ];
            }
        });
    }
}
