<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_id' => Invoice::inRandomOrder()->first()->id,
            'amount' => $this->faker->randomFloat(2, 10, 2000),
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed']),
            'payment_date' => $this->faker->date(),
            'method' => $this->faker->randomElement(['credit_card', 'bank_transfer', 'cash']),
        ];
    }
}
