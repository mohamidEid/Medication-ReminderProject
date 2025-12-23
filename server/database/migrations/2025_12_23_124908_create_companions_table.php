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
        Schema::create('companions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('companion_id')->constrained('users')->onDelete('cascade');
            $table->string('relationship')->nullable(); // mother, father, son, daughter, friend, caregiver
            $table->json('permissions')->nullable(); // ['view_medications', 'view_doses', 'receive_alerts', 'manage_medications']
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->string('invitation_token')->nullable()->unique();
            $table->timestamp('invitation_sent_at')->nullable();
            $table->timestamp('invitation_accepted_at')->nullable();
            $table->timestamps();

            // Prevent duplicate companions
            $table->unique(['patient_id', 'companion_id']);

            // Indexes
            $table->index('patient_id');
            $table->index('companion_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companions');
    }
};
