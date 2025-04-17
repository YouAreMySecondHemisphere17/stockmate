<?php

namespace Database\Factories;

use App\Models\Category;
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
        return [
            'category_id' => Category::all()->random()->id,
            'product_name' => substr($this->faker->unique()->word, 0, rand(3, 100)),
            'details' => $this->faker->text(200),
            'sold_price' => $this->faker->randomFloat(2, 1, 100),
            'current_stock' => 0,
            'minimum_stock' =>  $this->faker->numberBetween(10, 100),
        ];
    }
}
