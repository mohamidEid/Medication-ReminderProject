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
        Schema::create('user_behavior_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('medicine_id')->constrained()->onDelete('cascade');
            $table->time('scheduled_time');
            $table->time('actual_time')->nullable();
            $table->integer('delay_minutes')->default(0); // Negative if early
            $table->date('date');
            $table->enum('action', ['taken', 'missed', 'delayed'])->default('taken');
            $table->timestamps();

            // Indexes for analytics
            $table->index(['user_id', 'medicine_id']);
            $table->index(['user_id', 'date']);
            $table->index('action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_behavior_analytics');
    }
};
