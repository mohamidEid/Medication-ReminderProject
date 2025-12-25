# 🐛 سجل المشاكل والحلول - MediRemind

هذا الملف يوثق **جميع المشاكل** التي تم مواجهتها أثناء التطوير والحلول المطبقة.

---

## 📋 فهرس المشاكل

1. [مشاكل Database](#1-مشاكل-database)
2. [مشاكل Filament](#2-مشاكل-filament)
3. [مشاكل SMS & Notifications](#3-مشاكل-sms--notifications)
4. [مشاكل Subscriptions](#4-مشاكل-subscriptions)
5. [مشاكل Routes](#5-مشاكل-routes)
6. [مشاكل UI/UX](#6-مشاكل-uiux)
7. [مشاكل Performance](#7-مشاكل-performance)

---

## 1. مشاكل Database

### ❌ المشكلة 1.1: خطأ في اسم العمود `scheduled_at`
**الوصف:**
```
SQLSTATE[42S22 ERROR: column "scheduled_at" does not exist
```

**السبب:**
- في migration الـ `doses` table، اسم العمود هو `scheduled_time`
- في كود `StatsOverview` widget، تم استخدام `scheduled_at`

**الحل:**
```php
// قبل (خطأ)
->whereDate('scheduled_at', today())

// بعد (صحيح)
->whereDate('scheduled_time', today())
```

**الملفات المتأثرة:**
- `app/Filament/Widgets/StatsOverview.php`

---

### ❌ المشكلة 1.2: `plan_type` NULL في Subscriptions

**الوصف:**
```
SQLSTATE[23502]: Not null violation: NULL value in column "plan_type"
```

**السبب:**
- `Subscription::updateOrCreate()` أحياناً لا يرسل `plan_type` في INSERT

**الحل:**
```php
// بدلاً من updateOrCreate
$sub = new \App\Models\Subscription();
$sub->forceFill([
    'user_id' => $userId,
    'plan_type' => 'monthly',
    // ...
])->save();
```

**الملفات المتأثرة:**
- `app/Filament/Resources/SubscriptionReceiptResource.php`

---

## 2. مشاكل Filament

### ❌ المشكلة 2.1: `stty: invalid argument` عند make:filament-page

**الوصف:**
```bash
php artisan make:filament-page SmsTest
# Error: stty: invalid argument
```

**السبب:**
- مشكلة في terminal emulation مع `laravel/prompts`
- البيئة لا تدعم `stty` بشكل صحيح

**الحل:**
- إنشاء الصفحة يدوياً بدون Artisan command
- إنشاء الملفات التالية:
  ```
  app/Filament/Pages/SmsTest.php
  resources/views/filament/pages/sms-test.blade.php
  ```

**الملفات المتأثرة:**
- جميع Filament Pages المُنشأة يدوياً

---

### ❌ المشكلة 2.2: عدم ظهور أزرار Approve/Reject

**الوصف:**
- أزرار الموافقة/الرفض لا تظهر في SubscriptionReceipts table

**السبب:**
- لم يتم تعريف `Tables\Actions\Action` بشكل صحيح
- Cache قديم في Filament

**الحل:**
```bash
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
```

**الملفات المتأثرة:**
- `app/Filament/Resources/SubscriptionReceiptResource.php`

---

## 3. مشاكل SMS & Notifications

### ❌ المشكلة 3.1: Lucide Icons لا تظهر

**الوصف:**
- الأيقونات `<i data-lucide="...">` لا تُحمّل

**السبب:**
- عدم استدعاء `lucide.createIcons()` بعد تحميل DOM

**الحل:**
```javascript
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
        
        // إعادة تحميل للمحتوى الديناميكي
        setInterval(() => {
            lucide.createIcons();
        }, 500);
    }
});
```

**الملفات المتأثرة:**
- `resources/views/layouts/dashboard.blade.php`
- `resources/views/medicines/index.blade.php`

---

### ❌ المشكلة 3.2: Twilio SDK غير مثبت

**الوصف:**
```
Undefined type 'Twilio\Rest\Client'
```

**السبب:**
- Package `twilio/sdk` غير مثبت

**الحل:**
```bash
composer require twilio/sdk
composer require guzzlehttp/guzzle
```

**الملفات المتأثرة:**
- `app/Services/Notifications/TwilioSmsProvider.php`
- `app/Services/NotificationService.php`

---

## 4. مشاكل Subscriptions

### ❌ المشكلة 4.1: الـ relationship `subscription` غير موجود

**الوصف:**
```blade
@if($subscription && $subscription->status === 'active')
# Error: Trying to get property 'status' of non-object
```

**السبب:**
- في `User` model، الـ relationship اسمه `subscriptions` (جمع)
- في Blade، يستخدم `subscription` (مفرد)

**الحل:**
```php
// في User.php
public function subscription(): HasOne
{
    return $this->hasOne(Subscription::class)->latestOfMany();
}
```

**الملفات المتأثرة:**
- `app/Models/User.php`

---

### ❌ المشكلة 4.2: نموذج الاشتراك يظهر رغم وجود طلب pending

**الوصف:**
- المستخدم يرسل طلب اشتراك
- الصفحة لا زالت تعرض نموذج "اشترك الآن"
- يجب عرض "انتظر المراجعة"

**السبب:**
- الشرط `@if` معقد جداً
- عدم تحميل الـ relationships

**الحل:**
```blade
@php
    $hasPendingRequest = Auth::user()->subscriptionReceipts()
        ->where('status', 'pending')->exists();
@endphp

@if($hasPendingRequest)
    <!-- عرض "انتظر المراجعة" -->
@elseif($subscription && $subscription->status === 'active')
    <!-- عرض تفاصيل الاشتراك -->
@else
    <!-- عرض نموذج الاشتراك -->
@endif
```

**الملفات المتأثرة:**
- `resources/views/subscription/create.blade.php`

---

## 5. مشاكل Routes

### ❌ المشكلة 5.1: `web.medicines.index` route لا يوجد

**الوصف:**
```
Route [web.medicines.index] not defined
```

**السبب:**
- في `MedicineController`، استخدام `redirect()->route('web.medicines.index')`
- لكن الـ route اسمه `medicines.index` فقط

**الحل:**
```php
// قبل (خطأ)
return redirect()->route('web.medicines.index');

// بعد (صحيح)
return redirect()->route('medicines.index');
```

**الملفات المتأثرة:**
- `app/Http/Controllers/MedicineController.php`

---

### ❌ المشكلة 5.2: `medicines.destroy` route غير موجود

**الوصف:**
- زر الحذف لا يعمل
- خطأ: Route not defined

**السبب:**
- في `web.php`، استخدام `Route::resource` بدون `destroy`

**الحل:**
```php
Route::resource('medicines', MedicineController::class)
    ->middleware(['auth'])
    ->names([
        'index' => 'medicines.index',
        'create' => 'medicines.create',
        'store' => 'medicines.store',
        'show' => 'medicines.show',
        'edit' => 'medicines.edit',
        'update' => 'medicines.update',
        'destroy' => 'medicines.destroy', // ✅ إضافة destroy
    ]);
```

**الملفات المتأثرة:**
- `routes/web.php`

---

## 6. مشاكل UI/UX

### ❌ المشكلة 6.1: أيقونة الحذف لا تظهر

**الوصف:**
- في medicines index، زر الحذف (trash icon) لا يظهر

**السبب:**
- `<i data-lucide="trash-2">` لا يُحمّل

**الحل:**
استبدال Lucide icon بـ SVG مباشر:
```html
<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
</svg>
```

**الملفات المتأثرة:**
- `resources/views/medicines/index.blade.php`

---

### ❌ المشكلة 6.2: DELETE form method لا يعمل

**الوصف:**
- form الحذف يرسل POST بدلاً من DELETE

**السبب:**
- استخدام `method="DELETE"` مباشرة (غير مدعوم في HTML)

**الحل:**
```html
<form action="..." method="POST">
    @csrf
    @method('DELETE')
    <button type="submit">حذف</button>
</form>
```

**الملفات المتأثرة:**
- `resources/views/medicines/index.blade.php`

---

## 7. مشاكل Performance

### ❌ المشكلة 7.1: N+1 Query Problem

**الوصف:**
- في Filament Tables، تحميل بطيء بسبب queries متعددة

**السبب:**
- عدم استخدام `with()` eager loading

**الحل:**
```php
// في Resource
public static function table(Table $table): Table
{
    return $table
        ->query(SubscriptionReceipt::with(['user']))
        ->columns([...]);
}
```

**الملفات المتأثرة:**
- جميع Filament Resources

---

### ❌ المشكلة 7.2: Cache لا يُمسح بعد التعديلات

**الوصف:**
- بعد تعديل الكود، التغييرات لا تظهر

**السبب:**
- Laravel cache و Filament cache

**الحل:**
```bash
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

---

## 8. مشاكل تقنية أخرى

### ❌ المشكلة 8.1: User.php syntax error

**الوصف:**
```
ParseError: syntax error, unexpected token "public"
```

**السبب:**
- إضافة method بعد closing brace `}`
- استخدام `sed` command بشكل خاطئ

**الحل:**
```bash
# حذف الـ `}` الزائد
# التأكد من أن جميع methods داخل class
```

**الملفات المتأثرة:**
- `app/Models/User.php`

---

### ❌ المشكلة 8.2: File truncation

**الوصف:**
- ملف User.php تم قصّه (truncate) بالخطأ

**السبب:**
- PHP script لحذف سطر استخدم `file_put_contents` بشكل خاطئ

**الحل:**
```bash
# إعادة الملف من Git
git checkout app/Models/User.php

# أو إضافة closing brace يدوياً
echo "}" >> app/Models/User.php
```

---

## 🎯 الدروس المستفادة

### ✅ Best Practices

1. **Always use `with()` eager loading** في queries
2. **Clear cache** بعد كل تعديل مهم
3. **Test routes** قبل استخدامها
4. **Use `forceFill()`** بدل `create()` للـ critical data
5. **Validate inputs** قبل database operations
6. **Use SVG icons** بدل libraries إن أمكن
7. **Document everything** في comments

### ⚠️ الأخطاء الشائعة

1. ❌ عدم التحقق من أسماء الأعمدة في migrations
2. ❌ استخدام `updateOrCreate` بدون validation
3. ❌ نسيان `@method('DELETE')` في forms
4. ❌ عدم تحميل relationships قبل استخدامها
5. ❌ استخدام `sed` لتعديل PHP files (خطر!)
6. ❌ عدم اختبار الكود على clean cache

---

## 🛠 أدوات Debug مفيدة

### 1. Laravel Telescope
```bash
composer require laravel/telescope --dev
php artisan telescope:install
php artisan migrate
```

### 2. Laravel Debugbar
```bash
composer require barryvdh/laravel-debugbar --dev
```

### 3. Tinker Commands
```bash
# Test relationships
php artisan tinker
>>> $user = User::find(1);
>>> $user->subscription;

# Check queries
>>> DB::enableQueryLog();
>>> User::with('subscription')->get();
>>> DB::getQueryLog();
```

### 4. Useful Artisan Commands
```bash
# Clear everything
php artisan optimize:clear

# Check routes
php artisan route:list

# Test notifications
php artisan notification:test

# Check permissions
php artisan permission:cache-reset
```

---

## 📞 للدعم

إذا واجهت مشكلة جديدة، يُرجى:
1. التحقق من هذا الملف أولاً
2. فتح Issue على GitHub
3. التواصل: ydm07652@gmail.com

---

**آخر تحديث:** 2025-12-24
**الإصدار:** 1.0.0
