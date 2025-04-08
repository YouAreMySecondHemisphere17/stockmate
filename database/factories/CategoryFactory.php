<?php

namespace Database\Factories;

use App\Enums\CategoryStatusEnum;
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
            'name' => substr($this->faker->word, 0, rand(3, 50)),
            'status' => $this->faker->randomElement(CategoryStatusEnum::cases())->value,
        ];
    }
}
