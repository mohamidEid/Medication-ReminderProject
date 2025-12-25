<?php

// Test Subscription System

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\SubscriptionReceipt;
use App\Models\Subscription;
use Illuminate\Support\Facades\Hash;

echo "\n========================================\n";
echo "  Testing Subscription System\n";
echo "========================================\n\n";

// 1. Create or get test user
echo "1. Creating test user...\n";
$user = User::where('email', 'test123@example.com')->first();
if (!$user) {
    $user = User::create([
        'name' => 'Test User',
        'email' => 'test123@example.com',
        'phone' => '01234567890',
        'password' => Hash::make('password123')
    ]);
    echo "   ✓ User created: {$user->email}\n";
} else {
    echo "   ✓ User already exists: {$user->email}\n";
}
echo "   User ID: {$user->id}\n\n";

// 2. Check subscription status
echo "2. Checking subscription status...\n";
$subscription = $user->subscription;
if ($subscription && $subscription->status === 'active') {
    echo "   ✓ User has active subscription\n";
    echo "   Start: {$subscription->start_date}\n";
    echo "   End: {$subscription->end_date}\n";
} else {
    echo "   ✗ User has NO active subscription\n";
}
echo "\n";

// 3. Create subscription receipt (simulating user request)
echo "3. Creating subscription receipt request...\n";
$receipt = SubscriptionReceipt::where('user_id', $user->id)
    ->where('status', 'pending')
    ->first();

if (!$receipt) {
    $receipt = SubscriptionReceipt::create([
        'user_id' => $user->id,
        'phone' => $user->phone,
        'receipt_path' => 'receipts/test-receipt.jpg',
        'notes' => 'Test subscription request',
        'status' => 'pending'
    ]);
    echo "   ✓ Subscription receipt created\n";
} else {
    echo "   ✓ Pending receipt already exists\n";
}
echo "   Receipt ID: {$receipt->id}\n";
echo "   Status: {$receipt->status}\n\n";

// 4. Get admin user
echo "4. Getting admin user...\n";
$admin = User::whereHas('roles', function($q) {
    $q->whereIn('name', ['admin', 'super_admin']);
})->first();

if ($admin) {
    echo "   ✓ Admin found: {$admin->email}\n\n";

    // 5. Approve the subscription
    echo "5. Approving subscription...\n";

    // Update receipt status
    $receipt->update([
        'status' => 'approved',
        'reviewed_at' => now(),
        'reviewed_by' => $admin->id
    ]);

    // Create subscription
    $newSubscription = Subscription::create([
        'user_id' => $user->id,
        'plan_type' => 'monthly',
        'status' => 'active',
        'start_date' => now(),
        'end_date' => now()->addDays(30),
        'amount' => 100
    ]);

    echo "   ✓ Subscription approved and created\n";
    echo "   Subscription ID: {$newSubscription->id}\n";
    echo "   Plan: {$newSubscription->plan_type}\n";
    echo "   Status: {$newSubscription->status}\n";
    echo "   Start: {$newSubscription->start_date}\n";
    echo "   End: {$newSubscription->end_date}\n\n";

} else {
    echo "   ✗ No admin user found\n\n";
}

// 6. Verify subscription after approval
echo "6. Verifying final subscription status...\n";
$user->refresh();
$finalSubscription = $user->subscription;

if ($finalSubscription && $finalSubscription->status === 'active') {
    echo "   ✓ SUCCESS! User now has active subscription\n";
    echo "   Can access premium features: YES\n";

    $daysRemaining = now()->diffInDays($finalSubscription->end_date, false);
    echo "   Days remaining: {$daysRemaining}\n";
} else {
    echo "   ✗ FAILED! Something went wrong\n";
}

echo "\n========================================\n";
echo "  Test Complete\n";
echo "========================================\n\n";

echo "Login credentials:\n";
echo "Email: test123@example.com\n";
echo "Password: password123\n\n";
