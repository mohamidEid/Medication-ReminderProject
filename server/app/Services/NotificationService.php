<?php

namespace App\Services;

use App\Services\Notifications\SmsProviderInterface;
use App\Services\Notifications\TwilioSmsProvider;
use App\Services\Notifications\CustomSmsProvider;
use Illuminate\Support\Facades\Log;

/**
 * Notification Service
 * نظام شامل لإرسال الإشعارات عبر SMS, WhatsApp, Push
 */
class NotificationService
{
    protected $smsProvider;
    protected $whatsappProvider;

    public function __construct()
    {
        $this->smsProvider = $this->getSmsProvider();
    }

    /**
     * التحقق من الاشتراك النشط للمستخدم
     */
    public function hasActiveSubscription($user): bool
    {
        if (!$user) {
            return false;
        }

        return $user->subscription 
            && $user->subscription->status === 'active'
            && $user->subscription->end_date 
            && \Carbon\Carbon::parse($user->subscription->end_date)->isFuture();
    }

    /**
     * إرسال SMS
     */
    public function sendSms(string $to, string $message, $user = null): bool
    {
        if (!$this->smsProvider) {
            Log::warning("No SMS provider configured");
            return false;
        }

        // التحقق من الاشتراك إذا تم تمرير المستخدم
        if ($user && !$this->hasActiveSubscription($user)) {
            Log::info("SMS not sent - user has no active subscription: {$to}");
            return false;
        }

        return $this->smsProvider->send($to, $message);
    }

    /**
     * إرسال WhatsApp
     */
    public function sendWhatsApp(string $to, string $message, $user = null): bool
    {
        if (!$this->isWhatsAppConfigured()) {
            Log::info("WhatsApp not sent (not configured): {$to}");
            return false;
        }

        // التحقق من الاشتراك
        if ($user && !$this->hasActiveSubscription($user)) {
            Log::info("WhatsApp not sent - user has no active subscription: {$to}");
            return false;
        }

        try {
            $client = new \Twilio\Rest\Client(
                config('services.twilio.sid'),
                config('services.twilio.token')
            );

            $client->messages->create(
                "whatsapp:{$to}",
                [
                    'from' => config('services.twilio.whatsapp_from'),
                    'body' => $message
                ]
            );

            Log::info("WhatsApp sent to {$to}");
            return true;

        } catch (\Exception $e) {
            Log::error("WhatsApp failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * إرسال Push Notification
     */
    public function sendPushNotification(int $userId, string $title, string $message, array $data = []): bool
    {
        Log::info("Push notification (not implemented yet): User {$userId} - {$title}");
        return false;
    }

    /**
     * إرسال تذكير بالدواء (يتطلب اشتراك نشط)
     */
    public function sendMedicineReminder(string $phone, string $medicineName, string $time, $user = null): bool
    {
        // ✅ التحقق من الاشتراك النشط
        if ($user && !$this->hasActiveSubscription($user)) {
            Log::info("Medicine reminder not sent - user has no active subscription");
            return false;
        }

        $message = "🔔 تذكير: حان موعد دواء {$medicineName} في {$time}\n\nمن تطبيق MediRemind 💊";
        
        return $this->sendSms($phone, $message, $user);
    }

    /**
     * إرسال تنبيه نقص المخزون (يتطلب اشتراك نشط)
     */
    public function sendLowStockAlert(string $phone, string $medicineName, int $remaining, $user = null): bool
    {
        if ($user && !$this->hasActiveSubscription($user)) {
            Log::info("Low stock alert not sent - user has no active subscription");
            return false;
        }

        $message = "⚠️ تنبيه مخزون!\n\nدواء {$medicineName} على وشك النفاد\nالكمية المتبقية: {$remaining}\n\nMediRemind 💊";
        
        return $this->sendSms($phone, $message, $user);
    }

    /**
     * إرسال تأكيد الاشتراك (لا يتطلب اشتراك نشط)
     */
    public function sendSubscriptionConfirmation(string $phone, string $planName): bool
    {
        $message = "✅ تم تفعيل اشتراكك في {$planName} بنجاح!\n\nشكراً لثقتك في MediRemind 💊";
        
        // هذه الرسالة تُرسل بدون التحقق من الاشتراك
        return $this->smsProvider ? $this->smsProvider->send($phone, $message) : false;
    }

    /**
     * الحصول على SMS Provider
     */
    protected function getSmsProvider(): ?SmsProviderInterface
    {
        $provider = config('services.sms_provider', 'twilio');

        return match($provider) {
            'twilio' => new TwilioSmsProvider(),
            'custom' => new CustomSmsProvider(),
            default => null,
        };
    }

    /**
     * التحقق من تفعيل WhatsApp
     */
    protected function isWhatsAppConfigured(): bool
    {
        return !empty(config('services.twilio.sid')) &&
               !empty(config('services.twilio.token')) &&
               !empty(config('services.twilio.whatsapp_from'));
    }

    /**
     * الحصول على معلومات Provider الحالي
     */
    public function getProviderInfo(): array
    {
        return [
            'sms_provider' => $this->smsProvider ? $this->smsProvider->getName() : 'None',
            'sms_configured' => $this->smsProvider ? $this->smsProvider->isConfigured() : false,
            'whatsapp_configured' => $this->isWhatsAppConfigured(),
            'push_configured' => false,
        ];
    }
}
