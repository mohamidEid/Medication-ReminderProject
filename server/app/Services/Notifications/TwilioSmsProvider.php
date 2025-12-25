<?php

namespace App\Services\Notifications;

use Illuminate\Support\Facades\Log;

/**
 * Twilio SMS Provider
 * يمكنك استبداله بأي خدمة أخرى
 */
class TwilioSmsProvider implements SmsProviderInterface
{
    protected $client;
    protected $from;

    public function __construct()
    {
        // سيتم تفعيل Twilio عند إضافة الـ credentials
        if ($this->isConfigured()) {
            try {
                $this->client = new \Twilio\Rest\Client(
                    config('services.twilio.sid'),
                    config('services.twilio.token')
                );
                $this->from = config('services.twilio.phone_from');
            } catch (\Exception $e) {
                Log::error('Twilio initialization failed: ' . $e->getMessage());
            }
        }
    }

    public function send(string $to, string $message): bool
    {
        if (!$this->isConfigured()) {
            Log::info("SMS not sent (Twilio not configured): {$to} - {$message}");
            return false;
        }

        try {
            $this->client->messages->create($to, [
                'from' => $this->from,
                'body' => $message
            ]);

            Log::info("SMS sent via Twilio to {$to}");
            return true;
        } catch (\Exception $e) {
            Log::error("Twilio SMS failed: " . $e->getMessage());
            return false;
        }
    }

    public function getName(): string
    {
        return 'Twilio';
    }

    public function isConfigured(): bool
    {
        return !empty(config('services.twilio.sid')) &&
               !empty(config('services.twilio.token')) &&
               !empty(config('services.twilio.phone_from'));
    }
}
