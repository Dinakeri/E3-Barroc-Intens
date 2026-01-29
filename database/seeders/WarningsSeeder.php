<?php

namespace Database\Seeders;

use App\Services\WarningService;
use Illuminate\Database\Seeder;

class WarningsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Example: Create a few test warnings
        // When you implement low stock logic, you can call these methods:
        
        // WarningService::createLowStockWarning(1, 'Koffiemachine X200', 2, 10);
        // WarningService::createLowStockWarning(2, 'Koffie bonen Premium', 0, 50);
        // WarningService::createOverdueOrderWarning(5, 'ORD-2024-005', 10);
        
        // For demo purposes, create a couple warnings:
        \App\Models\Warning::create([
            'type' => 'low_stock',
            'title' => 'Lage voorraad',
            'message' => 'Meerdere producten hebben een lage voorraad',
            'severity' => 'warning',
            'is_resolved' => false,
        ]);

        \App\Models\Warning::create([
            'type' => 'system',
            'title' => 'Systeem update beschikbaar',
            'message' => 'Er is een nieuwe versie beschikbaar',
            'severity' => 'info',
            'is_resolved' => false,
        ]);
    }
}
