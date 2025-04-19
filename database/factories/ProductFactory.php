<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Vendor;
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
            'vendor_id' => Vendor::all()->random()->id,
            'product_name' => substr($this->faker->unique()->word, 0, rand(3, 100)),
            'details' => $this->faker->text(200),
            'purchase_price' => $this->faker->randomFloat(2, 1, 100),
            'sold_price' => function (array $attributes) {
                $purchasePrice = $attributes['purchase_price'];
                return round($purchasePrice * 1.40, 2); // 40% más que el precio de compra
            },
            'current_stock' => 0,
            'minimum_stock' =>  $this->faker->numberBetween(10, 100),
        ];
    }
}
