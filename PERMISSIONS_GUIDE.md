# 🔐 نظام الصلاحيات - Filament Admin Panel

## ✅ تم التنصيب بنجاح!

### 📦 ما تم إضافته:

1. **Spatie Laravel Permission** - أقوى نظام صلاحيات في Laravel
2. **3 أدوار (Roles)**:
   - **Super Admin** - صلاحيات كاملة
   - **Admin** - صلاحيات إدارية
   - **User** - صلاحيات المستخدم العادي

3. **49 صلاحية (Permissions)** تغطي:
   - إدارة المستخدمين
   - إدارة الأدوية
   - إدارة الجرعات
   - إدارة الإشتراكات
   - التنبيهات
   - المرافقين
   - الإعدادات

---

## 🔑 بيانات الدخول:

### Super Admin:
```
Email: admin@mediremind.com
Password: admin123
```

### الحساب السحري (تم ترقيته إلى Admin):
```
Email: magic@app.com
Password: Super$trong!P@ss2025
```

---

## 🌐 الوصول للـ Admin Panel:

افتح: **http://127.0.0.1:8000/admin**

سجل دخول بحساب **Super Admin** أو **Admin**

---

## 🛠️ كيفية استخدام الصلاحيات في الكود:

### في Controllers:
```php
// التحقق من الصلاحية
if (auth()->user()->can('view users')) {
    // يمكن عرض المستخدمين
}

// التحقق من الدور
if (auth()->user()->hasRole('admin')) {
    // هو أدمن
}
```

### في Blade:
```blade
@can('edit medicines')
    <button>تعديل الدواء</button>
@endcan

@role('admin')
    <a href="/admin">لوحة التحكم</a>
@endrole
```

### في Routes:
```php
Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin/settings', ...);
});

Route::middleware(['permission:manage alerts'])->group(function () {
    Route::post('/alerts/delete', ...);
});
```

### في Filament Resources:
```php
// في أي Resource
public static function canViewAny(): bool
{
    return auth()->user()->can('view medicines');
}

public static function canCreate(): bool
{
    return auth()->user()->can('create medicines');
}
```

---

## 📋 كل الصلاحيات المتاحة:

### Users:
- view users
- create users
- edit users
- delete users

### Medicines:
- view medicines
- create medicines
- edit medicines
- delete medicines

### Doses:
- view doses
- create doses
- edit doses
- delete doses

### Subscriptions:
- view subscriptions
- create subscriptions
- edit subscriptions
- delete subscriptions

### Others:
- view alerts
- manage alerts
- view companions
- manage companions
- manage settings
- view analytics

---

## 🎯 إضافة صلاحيات جديدة:

```php
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

// إنشاء صلاحية جديدة
Permission::create(['name' => 'export reports']);

// إعطاء الصلاحية لدور معين
$admin = Role::findByName('admin');
$admin->givePermissionTo('export reports');

// إعطاء الصلاحية لمستخدم مباشرة
$user->givePermissionTo('export reports');
```

---

## 🔄 إنشاء دور جديد:

```php
php artisan tinker

$role = Role::create(['name' => 'moderator']);
$role->givePermissionTo(['view users', 'edit users']);
```

---

## 👥 تعيين دور لمستخدم:

```php
$user = User::find(1);
$user->assignRole('admin');

// أو من Tinker
php artisan tinker
$user = User::where('email', 'user@example.com')->first();
$user->assignRole('admin');
```

---

## ⚙️ تنظيف الـ Cache:

```bash
php artisan permission:cache-reset
php artisan optimize:clear
```

---

## 🎉 جاهز للاستخدام!

**افتح الآن**: http://127.0.0.1:8000/admin

سجل دخول بحساب Super Admin وابدأ في إدارة الصلاحيات! 🚀
