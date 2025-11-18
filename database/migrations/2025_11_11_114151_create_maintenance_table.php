<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->integer('Company')->nullable();
            $table->integer('ContactPerson')->nullable();
            $table->string('Title');
            $table->text('Content');
            $table->integer('Product')->nullable();
            $table->date('Date');
            $table->integer('AssignedTo')->nullable();
            $table->integer('Part_ID')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance');
        Schema::dropIfExists('maintenances');
    }
};
