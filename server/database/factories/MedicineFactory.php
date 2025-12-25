<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicineFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->randomElement(['Paracetamol', 'Ibuprofen', 'Aspirin', 'Amoxicillin']),
            'dosage' => fake()->randomElement(['500mg', '250mg', '100mg']),
            'frequency' => fake()->randomElement(['daily', 'twice_daily', 'three_times_daily']),
            'start_date' => now()->format('Y-m-d'),
            'times' => json_encode(['08:00', '14:00', '20:00']),
            'instructions' => fake()->sentence(),
        ];
    }
}
