<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@mediremind.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('Admin@MediRemind2025!'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
