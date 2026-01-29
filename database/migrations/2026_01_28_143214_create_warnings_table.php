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
        Schema::create('warnings', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // e.g., 'low_stock', 'overdue_order', etc.
            $table->string('title');
            $table->text('message');
            $table->string('severity')->default('warning'); // 'info', 'warning', 'critical'
            $table->foreignId('related_id')->nullable(); // ID of related item (product, order, etc.)
            $table->string('related_type')->nullable(); // Type of related item
            $table->boolean('is_resolved')->default(false);
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warnings');
    }
};
