<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Finance User', 'email' => 'finance@example.test', 'role' => 'finance'],
            ['name' => 'Maintenance User', 'email' => 'maintenance@example.test', 'role' => 'maintenance'],
            ['name' => 'Sales User', 'email' => 'sales@example.test', 'role' => 'sales'],
            ['name' => 'No Role User', 'email' => 'none@example.test', 'role' => 'none'],
            ['name' => 'Admin User', 'email' => 'admin@example.test', 'role' => 'admin'],
        ];

        foreach ($users as $u) {
            User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'role' => $u['role'],
                    // Keep this simple for tests — password is "password"
                    'password' => Hash::make('password'),
                ]
            );
        }
    }
}
