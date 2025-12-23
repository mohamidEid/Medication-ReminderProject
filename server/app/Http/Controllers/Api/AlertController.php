<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Services\AlertService;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    protected AlertService $alertService;

    public function __construct(AlertService $alertService)
    {
        $this->alertService = $alertService;
    }

    /**
     * Get all active alerts for authenticated user
     */
    public function index(Request $request)
    {
        $type = $request->query('type');
        $alerts = $this->alertService->getActiveAlerts($request->user(), $type);

        return response()->json([
            'success' => true,
            'data' => $alerts,
            'unread_count' => $this->alertService->getUnreadCount($request->user()),
        ]);
    }

    /**
     * Mark alert as read
     */
    public function markAsRead($id)
    {
        $alert = Alert::where('user_id', auth()->id())
            ->findOrFail($id);

        $alert->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'تم وضع علامة مقروء على التنبيه',
        ]);
    }

    /**
     * Dismiss alert
     */
    public function dismiss($id)
    {
        $alert = Alert::where('user_id', auth()->id())
            ->findOrFail($id);

        $alert->dismiss();

        return response()->json([
            'success' => true,
            'message' => 'تم إخفاء التنبيه',
        ]);
    }

    /**
     * Mark all alerts as read
     */
    public function markAllAsRead(Request $request)
    {
        $count = $this->alertService->markAllAsRead($request->user());

        return response()->json([
            'success' => true,
            'message' => "تم وضع علامة مقروء على {$count} تنبيه",
            'count' => $count,
        ]);
    }

    /**
     * Run all alert checks
     */
    public function runChecks(Request $request)
    {
        $this->alertService->runAllChecks($request->user());

        return response()->json([
            'success' => true,
            'message' => 'تم فحص جميع التنبيهات',
        ]);
    }

    /**
     * Get unread count
     */
    public function unreadCount(Request $request)
    {
        return response()->json([
            'success' => true,
            'count' => $this->alertService->getUnreadCount($request->user()),
        ]);
    }
}
