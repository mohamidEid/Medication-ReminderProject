<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionReceipt;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubscriptionController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'receipt' => 'required|image|max:5120', // 5MB max
            'notes' => 'nullable|string|max:500',
        ]);

        // Store receipt image
        $path = $request->file('receipt')->store('receipts', 'public');

        // Create subscription receipt record
        SubscriptionReceipt::create([
            'user_id' => Auth::id(),
            'phone' => $request->phone,
            'receipt_path' => $path,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect()->route('subscription.create')
            ->with('success', 'تم إرسال طلب الاشتراك بنجاح! سيتم مراجعته خلال 5 دقائق.');
    }

    public function status()
    {
        $receipt = Auth::user()->subscriptionReceipts()->latest()->first();
        return view('subscription.status', compact('receipt'));
    }
}
