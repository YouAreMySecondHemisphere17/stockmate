<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

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
        $product = Product::all()->random();
        $quantity = $this->faker->numberBetween(1, 100);
        $total_amount = $product->purchase_price * $quantity;

        return [
            'product_id' => $product->id,
            'total_amount' => $total_amount,
            'quantity' => $quantity,
            'transaction_date' => $this->faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
        ];
    }
}
