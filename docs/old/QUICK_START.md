# 🚀 دليل التشغيل السريع - MediRemind

## خطوات التشغيل

### 1. تشغيل Backend (Laravel)

افتح Terminal جديد وقم بتنفيذ:

```bash
cd "Medication ReminderProject/server"
php artisan serve
```

✅ سيعمل API على: `http://localhost:8000`

### 2. تشغيل Frontend (React)

افتح Terminal آخر وقم بتنفيذ:

```bash
cd "Medication ReminderProject/client"
npm install  # فقط في المرة الأولى
npm run dev
```

✅ سيعمل التطبيق على: `http://localhost:3000`

## 🎯 الوصول للتطبيق

افتح المتصفح واذهب إلى: **http://localhost:3000**

## 📝 إنشاء حساب تجريبي

1. اضغط على "إنشاء حساب"
2. املأ البيانات:
   - الاسم: أي اسم
   - البريد: test@example.com
   - الهاتف: +20 123 456 7890
   - كلمة المرور: password123
3. اضغط "إنشاء حساب"

## ✨ المميزات المتاحة

- ✅ تسجيل دخول/إنشاء حساب
- ✅ لوحة تحكم Dashboard
- ✅ إضافة وإدارة الأدوية
- ✅ تتبع الجرعات
- ✅ إحصائيات الالتزام
- ✅ نظام الاشتراكات
- ✅ الوضع الليلي/النهاري
- ✅ اللغة العربية/الإنجليزية

## 🔧 حل المشاكل

### إذا واجهت مشكلة في Backend:
```bash
cd server
php artisan migrate:fresh  # إعادة إنشاء قاعدة البيانات
php artisan serve
```

### إذا واجهت مشكلة في Frontend:
```bash
cd client
rm -rf node_modules package-lock.json
npm install
npm run dev
```

## 📡 API Endpoints

يمكنك اختبار API باستخدام Postman أو curl:

```bash
# تسجيل حساب جديد
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "phone": "+20123456789",
    "password": "password123",
    "password_confirmation": "password123"
  }'

# تسجيل الدخول
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "password123"
  }'
```

## 🎨 تغيير اللغة والثيم

- **اللغة**: اضغط على أيقونة 🌍 في الـ Navbar
- **الثيم**: اضغط على أيقونة 🌙/☀️ في الـ Navbar

---

**ملاحظة**: تأكد من تشغيل Backend قبل Frontend!
