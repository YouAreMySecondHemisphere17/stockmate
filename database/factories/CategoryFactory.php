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
            'category_name' => ucfirst(
                substr(
                    str_replace('.', '', str_replace(' ', '', $this->faker->unique()->sentence(rand(1, 5)))),
                    0,
                    rand(3, 50)
                )
            ),
        ];
    }
}
