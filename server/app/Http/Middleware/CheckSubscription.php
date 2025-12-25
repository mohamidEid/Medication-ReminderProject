<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware to check if user has active subscription
 * Redirects to subscription page if subscription is not active
 */
class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Allow admins to bypass subscription check
        if ($user && $user->hasRole(['super_admin', 'admin'])) {
            return $next($request);
        }

        // Check if user has active subscription
        $subscription = $user?->subscription;

        if (!$subscription || $subscription->status !== 'active') {
            // If AJAX request, return JSON response
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'يجب أن يكون لديك اشتراك نشط للوصول إلى هذه الميزة',
                    'subscription_required' => true,
                ], 403);
            }

            // Otherwise redirect to subscription page
            return redirect()
                ->route('subscription.create')
                ->with('warning', 'يجب الاشتراك للوصول إلى جميع المميزات');
        }

        // Check if subscription has expired
        if ($subscription->end_date && $subscription->end_date->isPast()) {
            $subscription->update(['status' => 'expired']);

            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'انتهت صلاحية اشتراكك، يرجى التجديد',
                    'subscription_expired' => true,
                ], 403);
            }

            return redirect()
                ->route('subscription.create')
                ->with('warning', 'انتهت صلاحية اشتراكك، يرجى التجديد');
        }

        return $next($request);
    }
}
