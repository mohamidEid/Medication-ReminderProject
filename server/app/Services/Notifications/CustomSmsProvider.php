<?php

namespace App\Services\Notifications;

use Illuminate\Support\Facades\Log;

/**
 * Custom SMS Provider
 * استخدم هذا لإضافة أي خدمة SMS أخرى
 * مثال: Nexmo, MSG91, Infobip, etc.
 */
class CustomSmsProvider implements SmsProviderInterface
{
    protected $apiKey;
    protected $apiUrl;
    protected $from;

    public function __construct()
    {
        $this->apiKey = config('services.custom_sms.api_key');
        $this->apiUrl = config('services.custom_sms.api_url');
        $this->from = config('services.custom_sms.from');
    }

    public function send(string $to, string $message): bool
    {
        if (!$this->isConfigured()) {
            Log::info("SMS not sent (Custom provider not configured): {$to} - {$message}");
            return false;
        }

        try {
            // مثال على كيفية إرسال الـ SMS
            // عدل هذا حسب API الخدمة التي تستخدمها

            $response = \Http::post($this->apiUrl, [
                'api_key' => $this->apiKey,
                'to' => $to,
                'from' => $this->from,
                'message' => $message,
            ]);

            if ($response->successful()) {
                Log::info("SMS sent via Custom provider to {$to}");
                return true;
            }

            Log::error("Custom SMS failed: " . $response->body());
            return false;

        } catch (\Exception $e) {
            Log::error("Custom SMS exception: " . $e->getMessage());
            return false;
        }
    }

    public function getName(): string
    {
        return 'Custom SMS Provider';
    }

    public function isConfigured(): bool
    {
        return !empty($this->apiKey) && !empty($this->apiUrl);
    }
}
