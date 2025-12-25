<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\SubscriptionReceipt;
use Carbon\Carbon;

/**
 * Subscription Service
 *
 * Handles all subscription-related business logic
 */
class SubscriptionService
{
    /**
     * Create a new subscription receipt (payment request)
     *
     * @param int $userId
     * @param array $data
     * @return SubscriptionReceipt
     */
    public function createSubscriptionReceipt(int $userId, array $data): SubscriptionReceipt
    {
        return SubscriptionReceipt::create([
            'user_id' => $userId,
            'phone' => $data['phone'],
            'receipt_path' => $data['receipt_path'],
            'notes' => $data['notes'] ?? null,
            'status' => 'pending',
        ]);
    }

    /**
     * Approve subscription receipt and create active subscription
     *
     * @param SubscriptionReceipt $receipt
     * @param int $reviewerId
     * @return Subscription
     */
    public function approveSubscription(SubscriptionReceipt $receipt, int $reviewerId): Subscription
    {
        // Update receipt status
        $receipt->update([
            'status' => 'approved',
            'reviewed_at' => now(),
            'reviewed_by' => $reviewerId,
        ]);

        // Delete old subscriptions
        Subscription::where('user_id', $receipt->user_id)->delete();

        // Create new active subscription
        $subscription = new Subscription();
        $subscription->forceFill([
            'user_id' => $receipt->user_id,
            'plan_type' => 'monthly',
            'status' => 'active',
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'payment_id' => $receipt->id,
            'amount' => 100,
        ])->save();

        return $subscription;
    }

    /**
     * Reject subscription receipt
     *
     * @param SubscriptionReceipt $receipt
     * @param string $reason
     * @param int $reviewerId
     * @return SubscriptionReceipt
     */
    public function rejectSubscription(SubscriptionReceipt $receipt, string $reason, int $reviewerId): SubscriptionReceipt
    {
        $receipt->update([
            'status' => 'rejected',
            'admin_notes' => $reason,
            'reviewed_at' => now(),
            'reviewed_by' => $reviewerId,
        ]);

        return $receipt;
    }

    /**
     * Check if user has active subscription
     *
     * @param int $userId
     * @return bool
     */
    public function hasActiveSubscription(int $userId): bool
    {
        $subscription = Subscription::where('user_id', $userId)
            ->where('status', 'active')
            ->first();

        if (!$subscription) {
            return false;
        }

        return $subscription->end_date && Carbon::parse($subscription->end_date)->isFuture();
    }

    /**
     * Get user's active subscription
     *
     * @param int $userId
     * @return Subscription|null
     */
    public function getActiveSubscription(int $userId): ?Subscription
    {
        return Subscription::where('user_id', $userId)
            ->where('status', 'active')
            ->where('end_date', '>', now())
            ->first();
    }

    /**
     * Check if user has pending subscription request
     *
     * @param int $userId
     * @return bool
     */
    public function hasPendingRequest(int $userId): bool
    {
        return SubscriptionReceipt::where('user_id', $userId)
            ->where('status', 'pending')
            ->exists();
    }

    /**
     * Get subscription statistics
     *
     * @return array
     */
    public function getStatistics(): array
    {
        return [
            'total_active' => Subscription::where('status', 'active')->count(),
            'pending_requests' => SubscriptionReceipt::where('status', 'pending')->count(),
            'approved_today' => SubscriptionReceipt::where('status', 'approved')
                ->whereDate('reviewed_at', today())
                ->count(),
            'revenue_this_month' => Subscription::whereMonth('created_at', now()->month)
                ->sum('amount'),
        ];
    }
}
