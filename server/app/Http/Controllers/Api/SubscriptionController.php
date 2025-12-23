<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    public function current(Request $request)
    {
        $subscription = $request->user()->activeSubscription;

        if (!$subscription) {
            return response()->json([
                'plan' => 'free',
                'status' => 'active',
                'features' => $this->getPlanFeatures('free')
            ]);
        }

        return response()->json([
            'id' => $subscription->id,
            'plan' => $subscription->plan_type,
            'status' => $subscription->status,
            'start_date' => $subscription->start_date,
            'end_date' => $subscription->end_date,
            'amount' => $subscription->amount,
            'features' => $this->getPlanFeatures($subscription->plan_type)
        ]);
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'plan_type' => 'required|in:free,pro,family',
            'payment_id' => 'required_unless:plan_type,free|string',
        ]);

        $planPrices = [
            'free' => 0,
            'pro' => 49,
            'family' => 99,
        ];

        // Cancel any existing active subscription
        $request->user()->subscriptions()
            ->where('status', 'active')
            ->update(['status' => 'cancelled']);

        $subscription = $request->user()->subscriptions()->create([
            'plan_type' => $request->plan_type,
            'status' => 'active',
            'start_date' => now(),
            'end_date' => $request->plan_type !== 'free' ? now()->addMonth() : null,
            'payment_id' => $request->payment_id,
            'amount' => $planPrices[$request->plan_type],
        ]);

        return response()->json([
            'message' => 'Subscription created successfully',
            'subscription' => $subscription,
            'features' => $this->getPlanFeatures($request->plan_type)
        ], 201);
    }

    public function cancel(Request $request)
    {
        $subscription = $request->user()->activeSubscription;

        if (!$subscription) {
            return response()->json([
                'message' => 'No active subscription found'
            ], 404);
        }

        $subscription->update(['status' => 'cancelled']);

        return response()->json([
            'message' => 'Subscription cancelled successfully'
        ]);
    }

    private function getPlanFeatures($planType)
    {
        $features = [
            'free' => [
                'max_medicines' => 3,
                'push_notifications' => true,
                'whatsapp_notifications' => false,
                'sms_notifications' => false,
                'dose_history' => false,
                'reports' => false,
                'support' => 'limited',
            ],
            'pro' => [
                'max_medicines' => -1, // unlimited
                'push_notifications' => true,
                'whatsapp_notifications' => true,
                'sms_notifications' => true,
                'dose_history' => true,
                'reports' => true,
                'support' => '24/7',
            ],
            'family' => [
                'max_medicines' => -1, // unlimited
                'max_accounts' => 5,
                'push_notifications' => true,
                'whatsapp_notifications' => true,
                'sms_notifications' => true,
                'dose_history' => true,
                'reports' => true,
                'family_dashboard' => true,
                'support' => 'priority',
            ],
        ];

        return $features[$planType] ?? $features['free'];
    }
}
