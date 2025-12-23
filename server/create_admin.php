<?php

use Illuminate\Support\Facades\Hash;
use App\Models\User;

$user = User::where('email', 'admin@mediremind.com')->first();

if (!$user) {
    $user = User::create([
        'name' => 'Super Admin',
        'email' => 'admin@mediremind.com',
        'password' => Hash::make('admin123'),
        'is_admin' => true,
        'birthdate' => '1990-01-01',
        'phone' => '01000000000'
    ]);
    echo "✅ Admin created!\n";
    echo "📧 Email: admin@mediremind.com\n";
    echo "🔑 Password: admin123\n";
} else {
    $user->is_admin = true;
    $user->save();
    echo "✅ Admin already exists - is_admin set to true\n";
}
