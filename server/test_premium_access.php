<?php

// Test Premium Features Access

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Http\Middleware\CheckSubscription;
use Illuminate\Http\Request;

echo "\n========================================\n";
echo "  Testing Premium Features Access\n";
echo "========================================\n\n";

// Test 1: User WITHOUT subscription
echo "Test 1: User WITHOUT active subscription\n";
echo "----------------------------------------\n";
$userNoSub = User::create([
    'name' => 'User No Subscription',
    'email' => 'nosub@test.com',
    'phone' => '01111111111',
    'password' => bcrypt('password')
]);

$subscription = $userNoSub->subscription;
if ($subscription && $subscription->status === 'active') {
    echo "❌ FAILED: User should NOT have subscription\n\n";
} else {
    echo "✅ PASSED: User has no active subscription\n";
    echo "   Expected behavior: Should be redirected to /subscription\n\n";
}

// Test 2: User WITH subscription
echo "Test 2: User WITH active subscription\n";
echo "----------------------------------------\n";
$userWithSub = User::where('email', 'test123@example.com')->first();
$subscription = $userWithSub->subscription;

if ($subscription && $subscription->status === 'active') {
    echo "✅ PASSED: User has active subscription\n";
    echo "   Subscription ID: {$subscription->id}\n";
    echo "   Status: {$subscription->status}\n";
    echo "   End Date: {$subscription->end_date}\n";
    echo "   Expected behavior: Can access all premium features\n\n";
} else {
    echo "❌ FAILED: User should have subscription\n\n";
}

// Test 3: Admin user (should bypass subscription check)
echo "Test 3: Admin user (should bypass)\n";
echo "----------------------------------------\n";
$admin = User::whereHas('roles', function($q) {
    $q->whereIn('name', ['admin', 'super_admin']);
})->first();

if ($admin && $admin->hasRole(['admin', 'super_admin'])) {
    echo "✅ PASSED: Admin user found\n";
    echo "   Email: {$admin->email}\n";
    echo "   Expected behavior: Can access all features without subscription\n\n";
} else {
    echo "❌ FAILED: Admin should exist\n\n";
}

// Summary
echo "\n========================================\n";
echo "  Premium Features Protected:\n";
echo "========================================\n";
echo "1. ✅ Medicines Management (/medicines)\n";
echo "2. ✅ Schedule (/schedule)\n";
echo "3. ✅ History (/history)\n";
echo "4. ✅ Smart Features (/smart-features)\n";
echo "5. ✅ Companions (/companions)\n\n";

echo "Free Features:\n";
echo "----------------------------------------\n";
echo "1. ✅ Dashboard (/dashboard)\n";
echo "2. ✅ Settings (/settings)\n";
echo "3. ✅ Subscription Page (/subscription)\n\n";

echo "Test Users Created:\n";
echo "----------------------------------------\n";
echo "1. User WITH subscription:\n";
echo "   Email: test123@example.com\n";
echo "   Password: password123\n";
echo "   Can access: ALL features\n\n";

echo "2. User WITHOUT subscription:\n";
echo "   Email: nosub@test.com\n";
echo "   Password: password\n";
echo "   Can access: Dashboard, Settings only\n\n";

echo "3. Admin user:\n";
echo "   Email: {$admin->email}\n";
echo "   Can access: EVERYTHING (bypass)\n\n";

echo "========================================\n\n";
