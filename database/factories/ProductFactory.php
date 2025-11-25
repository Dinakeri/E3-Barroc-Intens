<?php

namespace Database\Factories;

use App\Models\Order;
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
            'name' => $this->faker->word(),
            'type' => $this->faker->word(),
            'cost_price' => $this->faker->randomFloat(2, 5, 500),
            'sales_price' => $this->faker->randomFloat(2, 10, 1000),
            'description' => $this->faker->sentence(),
            'stock' => $this->faker->numberBetween(0, 100),
            'status' => $this->faker->randomElement(['active', 'phased_out']),
            'length' => $this->faker->numberBetween(1, 200),
            'width' => $this->faker->numberBetween(1, 200),
            'breadth' => $this->faker->numberBetween(1, 200),
            'weight' => $this->faker->randomFloat(2, 0.1, 50),
            'order_id' => Order::inRandomOrder()->first()->id,
        ];
    }
}
