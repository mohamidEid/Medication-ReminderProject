# 📱 دليل نظام الإشعارات SMS & WhatsApp

## 🎯 نظرة عامة

تم إعداد نظام إشعارات شامل وقابل للتوسع يدعم:
- ✅ SMS عبر أي خدمة
- ✅ WhatsApp  
- ✅ Push Notifications (جاهز للتفعيل)

---

## 🔧 التكوين

### 1. إعداد `.env`

أضف هذه المتغيرات في ملف `.env`:

```env
# اختر Provider: twilio أو custom
SMS_PROVIDER=custom

# إعدادات Twilio (اختياري)
TWILIO_SID=your_twilio_sid
TWILIO_AUTH_TOKEN=your_twilio_token
TWILIO_PHONE_FROM=+1234567890
TWILIO_WHATSAPP_FROM=whatsapp:+14155238886

# إعدادات Custom SMS (أي خدمة أخرى)
CUSTOM_SMS_API_KEY=your_api_key
CUSTOM_SMS_API_URL=https://api.your-sms-service.com/send
CUSTOM_SMS_FROM=YourAppName
```

---

## 📝 كيفية الاستخدام

### في Controller:

```php
<?php

use App\Services\NotificationService;

class DoseController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function sendReminder($doseId)
    {
        $dose = Dose::find($doseId);
        
        // إرسال SMS
        $this->notificationService->sendMedicineReminder(
            $dose->user->phone,
            $dose->medicine->name,
            $dose->scheduled_time->format('h:i A')
        );

        // إرسال WhatsApp
        $this->notificationService->sendWhatsApp(
            $dose->user->phone,
            "🔔 تذكير: حان موعد دواء {$dose->medicine->name}"
        );
    }
}
```

### في Jobs/Commands:

```php
<?php

use App\Services\NotificationService;

class SendMedicineReminders extends Command
{
    public function handle()
    {
        $notificationService = app(NotificationService::class);
        
        $upcomingDoses = Dose::whereDate('scheduled_time', today())
            ->where('status', 'pending')
            ->get();

        foreach ($upcomingDoses as $dose) {
            $notificationService->sendSms(
                $dose->user->phone,
                "موعد دواء {$dose->medicine->name} اقترب!"
            );
        }
    }
}
```

---

## 🔌 إضافة Custom SMS Provider

### الخطوة 1: تعديل `CustomSmsProvider.php`

```php
// في app/Services/Notifications/CustomSmsProvider.php

public function send(string $to, string $message): bool
{
    try {
        // مثال: استخدام MSG91
        $response = \Http::post('https://api.msg91.com/api/v5/flow/', [
            'authkey' => $this->apiKey,
            'mobiles' => $to,
            'message' => $message,
            'sender' => $this->from,
        ]);

        // أو استخدام Nexmo
        $response = \Http::post('https://rest.nexmo.com/sms/json', [
            'api_key' => $this->apiKey,
            'api_secret' => $this->apiSecret,
            'to' => $to,
            'from' => $this->from,
            'text' => $message,
        ]);

        if ($response->successful()) {
            Log::info("SMS sent to {$to}");
            return true;
        }

        return false;
    } catch (\Exception $e) {
        Log::error("SMS failed: " . $e->getMessage());
        return false;
    }
}
```

### الخطوة 2: تحديث `.env`

```env
SMS_PROVIDER=custom
CUSTOM_SMS_API_KEY=your_actual_api_key
CUSTOM_SMS_API_URL=https://api.your-service.com/send
CUSTOM_SMS_FROM=MediRemind
```

---

## 🎨 أمثلة جاهزة

### تذكير بالدواء

```php
$notificationService->sendMedicineReminder(
    '+201234567890',
    'باراسيتامول 500mg',
    '08:00 AM'
);
```

### تنبيه نقص المخزون

```php
$notificationService->sendLowStockAlert(
    '+201234567890',
    'أسبرين',
    3 // الكمية المتبقية
);
```

### تأكيد الاشتراك

```php
$notificationService->sendSubscriptionConfirmation(
    '+201234567890',
    'باقة Pro'
);
```

### إرسال مخصص

```php
// SMS
$notificationService->sendSms(
    '+201234567890',
    'رسالتك هنا'
);

// WhatsApp
$notificationService->sendWhatsApp(
    '+201234567890',
    'رسالة WhatsApp'
);
```

---

## 🔍 التحقق من الإعدادات

```php
$notificationService = app(NotificationService::class);
$info = $notificationService->getProviderInfo();

// النتيجة:
[
    'sms_provider' => 'Custom SMS Provider',
    'sms_configured' => true,
    'whatsapp_configured' => false,
    'push_configured' => false,
]
```

---

## 🚀 خدمات SMS الموصى بها

### للسعودية ومصر:

1. **Twilio** - https://www.twilio.com
   - الأفضل والأكثر موثوقية
   - يدعم SMS و WhatsApp
   
2. **MSG91** - https://msg91.com
   - أسعار جيدة للشرق الأوسط
   
3. **Nexmo (Vonage)** - https://www.vonage.com
   - خيار قوي وموثوق
   
4. **Infobip** - https://www.infobip.com
   - ممتاز للشركات الكبيرة

### للسعودية فقط:

1. **Unifonic** - https://www.unifonic.com
2. **OTP Cloud** - https://www.otpcloud.com

---

## 📊 Logging

جميع الرسائل يتم تسجيلها في:
```
storage/logs/laravel.log
```

مثال:
```
[2025-12-23 15:30:00] local.INFO: SMS sent via Custom provider to +201234567890
[2025-12-23 15:31:00] local.WARNING: No SMS provider configured
[2025-12-23 15:32:00] local.ERROR: Custom SMS failed: API key invalid
```

---

## 🛠️ استكشاف الأخطاء

### المشكلة: "No SMS provider configured"

**الحل:**
```env
SMS_PROVIDER=custom
CUSTOM_SMS_API_KEY=your_key
CUSTOM_SMS_API_URL=your_url
```

### المشكلة: "SMS not sent"

**الحل:**
1. تحقق من الـ logs في `storage/logs/laravel.log`
2. تأكد من صحة API credentials
3. تأكد من تنسيق رقم الهاتف (مثال: +201234567890)

---

## 🔐 الأمان

- ✅ لا تضع API keys في الكود مباشرة
- ✅ استخدم `.env` دائماً
- ✅ أضف `.env` في `.gitignore`
- ✅ استخدم `config()` للوصول للمتغيرات

---

## 📈 الخطوات القادمة

1. ✅ اختر خدمة SMS
2. ✅ احصل على API credentials
3. ✅ أضف في `.env`
4. ✅ عدل `CustomSmsProvider.php` حسب الـ API
5. ✅ اختبر الإرسال

**جاهز للاستخدام! 🎉**
