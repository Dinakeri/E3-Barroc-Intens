<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Quote;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contract>
 */
class ContractFactory extends Factory
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
            'quote_id' => Quote::inRandomOrder()->first()->id,
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'total_amount' => $this->faker->randomFloat(2, 500, 10000),
            'status' => $this->faker->randomElement(['active', 'expired', 'terminated']),
        ];
    }
}
