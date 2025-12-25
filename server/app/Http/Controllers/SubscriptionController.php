<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionReceipt;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

/**
 * Subscription Controller
 *
 * Handles subscription requests and management
 */
class SubscriptionController extends Controller
{
    use \Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    /**
     * Create a new controller instance
     */
    public function __construct(
        protected SubscriptionService $subscriptionService
    ) {
        // Middleware is applied in routes/web.php
    }

    /**
     * Show subscription page
     */
    public function create(): View
    {
        return view('subscription.create');
    }

    /**
     * Submit subscription request with payment receipt
     */
    public function submit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'phone' => ['required', 'string', 'max:20'],
            'receipt_image' => ['required', 'image', 'max:5120'], // 5MB max
            'notes' => ['nullable', 'string', 'max:500'],
        ], [
            'phone.required' => 'رقم الهاتف مطلوب',
            'receipt_image.required' => 'صورة الإيصال مطلوبة',
            'receipt_image.image' => 'يجب أن تكون صورة',
            'receipt_image.max' => 'حجم الصورة يجب أن لا يتجاوز 5 ميجابايت',
        ]);

        // Store receipt image
        $path = $request->file('receipt_image')->store('receipts', 'public');

        // Create subscription receipt via service
        $this->subscriptionService->createSubscriptionReceipt(
            Auth::id(),
            [
                'phone' => $validated['phone'],
                'receipt_path' => $path,
                'notes' => $validated['notes'] ?? null,
            ]
        );

        return redirect()
            ->route('subscription.create')
            ->with('success', 'تم إرسال طلب الاشتراك بنجاح! سيتم مراجعته خلال 5 دقائق.');
    }

    /**
     * Show subscription status
     */
    public function status(): View
    {
        $receipt = Auth::user()->subscriptionReceipts()->latest()->first();
        return view('subscription.status', compact('receipt'));
    }
}
