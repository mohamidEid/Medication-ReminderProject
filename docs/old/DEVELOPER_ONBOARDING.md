# Developer Onboarding - Docker Setup

## 👋 مرحباً بك في فريق تطوير Medication Reminder!

هذا دليل سريع لإعداد بيئة التطوير الخاصة بك باستخدام Docker.

## 📋 المتطلبات

قبل البدء، تأكد من تثبيت:

- [Docker](https://docs.docker.com/get-docker/) >= 20.10
- [Docker Compose](https://docs.docker.com/compose/install/) >= 2.0
- Git

## 🚀 خطوات الإعداد السريع

### 1️⃣ استنساخ المشروع

```bash
git clone <repository-url>
cd "Medication ReminderProject"
```

### 2️⃣ فحص المتطلبات

```bash
./docker-check.sh
```

هذا الأمر سيتحقق من:
- ✅ تثبيت Docker و Docker Compose
- ✅ تشغيل Docker daemon
- ✅ توفر المنافذ المطلوبة
- ✅ وجود ملفات التكوين

### 3️⃣ الإعداد التلقائي

```bash
./docker-setup.sh
```

أو باستخدام Makefile:

```bash
make install
```

### 4️⃣ التحقق من التشغيل

بعد اكتمال الإعداد، افتح المتصفح:

- **التطبيق**: http://localhost
- **لوحة الإدارة**: http://localhost/admin
- **phpMyAdmin**: http://localhost:8080

## 🔧 سير العمل اليومي

### بدء التطوير

```bash
# تشغيل الحاويات
make up

# أو
docker-compose up -d
```

### إيقاف العمل

```bash
# إيقاف الحاويات
make down

# أو
docker-compose down
```

### مشاهدة السجلات

```bash
# جميع الخدمات
make logs

# خدمة محددة
docker-compose logs -f app
docker-compose logs -f nginx
```

### تشغيل أوامر Artisan

```bash
# الدخول إلى shell التطبيق
make shell

# داخل shell
php artisan migrate
php artisan make:controller SomeController
php artisan queue:work

# أو مباشرة
docker-compose exec app php artisan migrate
```

### تثبيت حزم جديدة

```bash
# Composer
docker-compose exec app composer require package/name

# NPM
docker-compose exec app npm install package-name
```

### إعادة بناء الأصول (Assets)

```bash
docker-compose exec app npm run dev
# أو
docker-compose exec app npm run build
```

## 🗃️ قاعدة البيانات

### الوصول إلى MySQL CLI

```bash
make mysql

# أو
docker-compose exec mysql mysql -u medication_user -pmedication_password medication_db
```

### تشغيل Migrations

```bash
make migrate

# أو مع seed
make migrate-seed
```

### إعادة بناء قاعدة البيانات

```bash
make migrate-fresh
docker-compose exec app php artisan db:seed
```

## 🧹 التنظيف والصيانة

### مسح الـ Cache

```bash
make cache-clear
```

### إصلاح الأذونات

```bash
make permissions
```

### إعادة بناء الحاويات

```bash
make clean
make build
make up
```

### تنظيف كامل

```bash
make clean-all
```

## 🐛 استكشاف الأخطاء

### الحاويات لا تعمل؟

```bash
# التحقق من حالة الحاويات
docker-compose ps

# إعادة تشغيل
docker-compose restart

# عرض السجلات
docker-compose logs
```

### مشكلة في الأذونات؟

```bash
make permissions
```

### قاعدة البيانات لا تستجيب؟

```bash
docker-compose restart mysql
docker-compose logs mysql
```

### مشكلة في Queue أو Scheduler؟

```bash
docker-compose restart queue
docker-compose restart scheduler
docker-compose logs -f queue
docker-compose logs -f scheduler
```

## 📚 موارد إضافية

### الوثائق

- `DOCKER_START.md` - دليل البدء السريع
- `DOCKER_README_AR.md` - دليل سريع بالعربية
- `DOCKER_GUIDE.md` - دليل شامل
- `DOCKER_SUMMARY.md` - ملخص كامل
- `Makefile` - قائمة جميع الأوامر المتاحة

### الأوامر المتاحة في Makefile

```bash
make help
```

## 🔐 ملاحظات أمنية

⚠️ **لا ترفع ملفات حساسة إلى Git:**

- `.env` (مستبعد بالفعل)
- `docker/nginx/ssl/` (شهادات SSL)
- أي ملفات تحتوي على كلمات مرور

✅ استخدم `.env.example` كنموذج

## 🤝 المساهمة

عند إضافة ميزات جديدة:

1. أنشئ branch جديد
2. اختبر التغييرات محلياً باستخدام Docker
3. تأكد من تحديث الوثائق إذا لزم الأمر
4. أرسل Pull Request

## 💬 الحصول على المساعدة

إذا واجهت أي مشاكل:

1. راجع ملفات التوثيق
2. تحقق من السجلات: `make logs`
3. اسأل في قناة الفريق
4. افتح Issue على GitHub

---

**مرحباً بك في الفريق! 🎉**

نتطلع إلى مساهماتك!
