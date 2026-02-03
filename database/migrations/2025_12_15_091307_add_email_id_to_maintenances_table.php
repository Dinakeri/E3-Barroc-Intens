<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('maintenances', function (Blueprint $table) {
            $table->string('email_id')->nullable()->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maintenances', function (Blueprint $table) {
            if (DB::getDriverName() === 'sqlite') {
                // SQLite requires dropping the unique index before dropping the column
                DB::statement('DROP INDEX IF EXISTS maintenances_email_id_unique');
            }
            $table->dropColumn('email_id');
        });
    }
};
