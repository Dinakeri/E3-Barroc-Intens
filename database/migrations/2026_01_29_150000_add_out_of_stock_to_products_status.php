<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For SQLite, we don't need to do anything since it treats enums as text
        // The column already exists and can store 'out_of_stock' values
        // Just ensure the table exists and the migration is marked as done
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE products MODIFY COLUMN status ENUM('active','phased_out','out_of_stock') NOT NULL");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // SQLite doesn't support modifying enums, so no action needed for rollback
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE products MODIFY COLUMN status ENUM('active','phased_out') NOT NULL");
        }
    }
};
