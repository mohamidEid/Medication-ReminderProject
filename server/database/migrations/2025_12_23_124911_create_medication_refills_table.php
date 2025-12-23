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
        Schema::create('medication_refills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('medicine_id')->constrained()->onDelete('cascade');
            $table->decimal('quantity', 10, 2);
            $table->string('quantity_unit', 50)->default('pills');
            $table->text('notes')->nullable();
            $table->date('refill_date');
            $table->timestamps();

            // Indexes
            $table->index(['user_id', 'medicine_id']);
            $table->index('refill_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medication_refills');
    }
};
