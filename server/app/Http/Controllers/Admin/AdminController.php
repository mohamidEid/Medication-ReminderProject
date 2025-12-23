<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SubscriptionReceipt;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'active_subscriptions' => Subscription::where('status', 'active')->count(),
            'pending_receipts' => SubscriptionReceipt::where('status', 'pending')->count(),
            'total_revenue' => Subscription::where('status', 'active')->count() * 100, // 100 EGP per subscription
        ];

        $recentUsers = User::latest()->take(5)->get();
        $pendingReceipts = SubscriptionReceipt::where('status', 'pending')
            ->with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'pendingReceipts'));
    }

    public function subscriptions()
    {
        $receipts = SubscriptionReceipt::with('user', 'reviewer')
            ->latest()
            ->paginate(20);

        return view('admin.subscriptions', compact('receipts'));
    }

    public function approve(SubscriptionReceipt $receipt)
    {
        $receipt->update([
            'status' => 'approved',
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);

        // Create or extend subscription
        Subscription::create([
            'user_id' => $receipt->user_id,
            'plan' => 'monthly',
            'status' => 'active',
            'starts_at' => now(),
            'ends_at' => now()->addMonth(),
        ]);

        return back()->with('success', 'تم الموافقة على الاشتراك وتفعيله بنجاح!');
    }

    public function reject(SubscriptionReceipt $receipt, Request $request)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:500',
        ]);

        $receipt->update([
            'status' => 'rejected',
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
            'admin_notes' => $request->admin_notes,
        ]);

        return back()->with('success', 'تم رفض الاشتراك.');
    }

    public function users()
    {
        $users = User::with(['medicines', 'subscriptionReceipts'])
            ->withCount('medicines')
            ->latest()
            ->paginate(20);

        return view('admin.users', compact('users'));
    }
}
