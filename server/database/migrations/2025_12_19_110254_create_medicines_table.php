<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('dosage')->nullable();
            $table->string('type')->default('pill'); // pill, syrup, injection, etc.
            $table->string('frequency'); // daily, weekly, custom
            $table->json('times'); // ["09:00", "14:00"]
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('stock')->default(0);
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
