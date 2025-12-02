<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'email' => fake()->unique()->companyEmail(),
            'phone' => fake()->phoneNumber(),
            'contact_person' => fake()->name(),
            'street' => fake()->streetName(),
            'house_number' => fake()->buildingNumber(),
            'postcode' => fake()->postcode(),
            'place' => fake()->city(),
            'bkr_status' => fake()->randomElement(['pending', 'registered', 'cleared']),
            'kvk_number' => fake()->numberBetween(10000000, 99999999),
            'status' => fake()->randomElement(['new', 'active', 'pending', 'inactive']),
            'notes' => fake()->paragraph(),
        ];
    }
}
