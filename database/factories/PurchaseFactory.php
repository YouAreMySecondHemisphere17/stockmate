<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Vendor;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchase>
 */
class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::all()->random()->id,
            'vendor_id' => Vendor::all()->random()->id,
            'price' => $this->faker->randomFloat(2, 1, 30),
            'quantity' => $this->faker->numberBetween(1, 100),
            'transaction_date' => $this->faker->date('Y-m-d'), 
        ];
    }
}
