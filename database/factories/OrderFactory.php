<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate a random date within the last 6 months
        $createdAt = $this->faker->dateTimeBetween('-6 months', 'now');
        
        return [
            'customer_id' => Customer::inRandomOrder()->first()->id ,
            'order_date' => $this->faker->date(),
            'total_amount' => $this->faker->randomFloat(2, 20, 1000),
            'status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']),
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ];
    }
}
