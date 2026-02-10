<?php

namespace Database\Factories;

use App\Models\Contract;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::inRandomOrder()->first()->id,
            'order_id' => Order::inRandomOrder()->first()->id,
            'contract_id' => Contract::inRandomOrder()->first()->id,
            'total_amount' => $this->faker->randomFloat(2, 50, 5000),
            'valid_until' => $this->faker->date(),
            'pdf_path' => $this->faker->filePath(),
            'status' => $this->faker->randomElement(['draft', 'sent', 'paid', 'cancelled']),
        ];
    }
}
