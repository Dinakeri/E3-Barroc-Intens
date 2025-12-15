<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // You can keep the factory example if you want more random users.
        // User::factory(10)->create();

        // Create deterministic test users for each department/role
        $this->call(TestUsersSeeder::class);
        $this->call(CustomersSeeder::class);
        $this->call(OrdersSeeder::class);
        $this->call(ProdcutsSeeder::class);
        $this->call(OrderItemsSeeder::class);
        $this->call(InvoicesSeeder::class);
        $this->call(PaymentsSeeder::class);
    }
}
