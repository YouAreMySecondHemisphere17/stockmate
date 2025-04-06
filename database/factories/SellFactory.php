<?php

namespace Database\Factories;

use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sell>
 */
class SellFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1, 
            'customer_id' => 1, 
            'branch_id' => 1, 
            'total_amount' => $this->faker->randomFloat(2, 20, 500),
            'paid_amount' => $this->faker->randomFloat(2, 0, 500),
            'sell_date' => $this->faker->date('Y-m-d'),
            'discount_amount' => $this->faker->randomFloat(2, 0, 50),
            'payment_method' => $this->faker->randomElement(PaymentMethodEnum::cases())->value,
            'payment_status' => $this->faker->randomElement(PaymentStatusEnum::cases())->value,
        ];
    }
}
