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
        // Update all users with role 'none' to 'admin'
        DB::table('users')
            ->where('role', 'none')
            ->update(['role' => 'admin']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert admin users back to none
        DB::table('users')
            ->where('role', 'admin')
            ->update(['role' => 'none']);
    }
};
