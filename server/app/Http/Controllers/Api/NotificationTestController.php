<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\Request;

/**
 * Test Notification Controller
 * استخدم هذا لاختبار الـ SMS و WhatsApp
 */
class NotificationTestController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * اختبار SMS
     */
    public function testSms(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'message' => 'required|string|max:160',
        ]);

        $sent = $this->notificationService->sendSms(
            $request->phone,
            $request->message
        );

        return response()->json([
            'success' => $sent,
            'message' => $sent ? 'SMS sent successfully' : 'SMS failed to send',
            'provider_info' => $this->notificationService->getProviderInfo(),
        ]);
    }

    /**
     * اختبار WhatsApp
     */
    public function testWhatsApp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'message' => 'required|string',
        ]);

        $sent = $this->notificationService->sendWhatsApp(
            $request->phone,
            $request->message
        );

        return response()->json([
            'success' => $sent,
            'message' => $sent ? 'WhatsApp sent successfully' : 'WhatsApp failed to send',
        ]);
    }

    /**
     * الحصول على معلومات Provider
     */
    public function getProviderInfo()
    {
        return response()->json([
            'provider' => $this->notificationService->getProviderInfo(),
        ]);
    }

    /**
     * اختبار تذكير بالدواء
     */
    public function testMedicineReminder(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'medicine_name' => 'required|string',
            'time' => 'required|string',
        ]);

        $sent = $this->notificationService->sendMedicineReminder(
            $request->phone,
            $request->medicine_name,
            $request->time
        );

        return response()->json([
            'success' => $sent,
            'message' => $sent ? 'Reminder sent' : 'Reminder failed',
        ]);
    }
}
