# 🐳 دليل Docker السريع - مشروع تذكير الدواء

## 📋 المتطلبات

- Docker >= 20.10
- Docker Compose >= 2.0

## 🚀 البدء السريع

### الطريقة الأولى: التثبيت التلقائي (موصى به)

```bash
chmod +x docker-setup.sh
./docker-setup.sh
```

### الطريقة الثانية: استخدام Makefile

```bash
make install
```

### الطريقة الثالثة: يدوياً

```bash
# 1. نسخ ملف البيئة
cp server/.env.example server/.env

# 2. تشغيل الحاويات
docker-compose up -d --build

# 3. توليد مفتاح التطبيق
docker-compose exec app php artisan key:generate

# 4. تشغيل migrations
docker-compose exec app php artisan migrate

# 5. إنشاء رابط التخزين
docker-compose exec app php artisan storage:link
```

## 🌐 الوصول إلى التطبيق

| الخدمة | الرابط |
|--------|--------|
| التطبيق الرئيسي | http://localhost |
| لوحة الإدارة (Filament) | http://localhost/admin |
| phpMyAdmin | http://localhost:8080 |

## 🛠️ الأوامر الأساسية

### باستخدام Makefile

```bash
make help              # عرض جميع الأوامر المتاحة
make up                # تشغيل الحاويات
make down              # إيقاف الحاويات
make restart           # إعادة تشغيل الحاويات
make logs              # عرض السجلات
make shell             # الدخول إلى shell التطبيق
make migrate           # تشغيل migrations
make cache             # تخزين التكوينات
make cache-clear       # مسح التخزين المؤقت
make backup-db         # نسخ احتياطي للقاعدة
```

### باستخدام Docker Compose مباشرة

```bash
# إدارة الحاويات
docker-compose up -d              # تشغيل
docker-compose down               # إيقاف
docker-compose restart            # إعادة تشغيل
docker-compose logs -f            # السجلات

# تشغيل أوامر Laravel
docker-compose exec app php artisan migrate
docker-compose exec app php artisan cache:clear
docker-compose exec app composer install

# الدخول إلى shell
docker-compose exec app bash
docker-compose exec mysql mysql -u medication_user -pmedication_password medication_db
```

## 📦 الخدمات المتوفرة

| الخدمة | الوصف | المنفذ |
|--------|-------|--------|
| app | تطبيق Laravel (PHP 8.2) | - |
| nginx | خادم الويب | 80, 443 |
| mysql | قاعدة البيانات | 3306 |
| redis | التخزين المؤقت | 6379 |
| queue | معالج الطوابير | - |
| scheduler | مجدول المهام | - |
| phpmyadmin | إدارة قاعدة البيانات | 8080 |

## 🔧 المشاكل الشائعة وحلولها

### مشكلة الأذونات

```bash
make permissions
# أو
docker-compose exec app chown -R www-data:www-data /var/www/html/storage
docker-compose exec app chmod -R 755 /var/www/html/storage
```

### إعادة بناء الحاويات من الصفر

```bash
make clean-all
make build
make up
```

### مشكلة في قاعدة البيانات

```bash
docker-compose restart mysql
docker-compose logs mysql
```

## 💾 النسخ الاحتياطي والاستعادة

### النسخ الاحتياطي

```bash
# باستخدام Makefile
make backup-db

# يدوياً
docker-compose exec mysql mysqldump -u medication_user -pmedication_password medication_db > backup.sql
```

### الاستعادة

```bash
# باستخدام Makefile
make restore-db FILE=backup.sql

# يدوياً
docker-compose exec -T mysql mysql -u medication_user -pmedication_password medication_db < backup.sql
```

## 🚢 النشر للإنتاج

### 1. تحديث ملف البيئة

```bash
cp .env.docker.example server/.env
# قم بتحديث القيم في server/.env
```

### 2. النشر

```bash
make deploy
# أو
docker-compose -f docker-compose.prod.yml up -d --build
```

## 📊 المراقبة

### عرض حالة الحاويات

```bash
docker-compose ps
# أو
make ps
```

### عرض استخدام الموارد

```bash
docker stats
```

### عرض السجلات

```bash
# جميع الخدمات
docker-compose logs -f

# خدمة معينة
docker-compose logs -f app
docker-compose logs -f nginx
docker-compose logs -f mysql
```

## 🔐 الأمان (للإنتاج)

1. **تغيير كلمات المرور الافتراضية** في ملف `.env`:
   - `DB_PASSWORD`
   - `DB_ROOT_PASSWORD`
   - `REDIS_PASSWORD`

2. **تفعيل SSL**:
   - ضع الشهادات في `docker/nginx/ssl/`
   - استخدم ملف `docker/nginx/default.ssl.conf`

3. **تعطيل phpMyAdmin** في الإنتاج

4. **استخدام Firewall** لتقييد الوصول للمنافذ

## 📚 ملفات مهمة

```
├── Dockerfile                      # تعريف صورة التطبيق
├── docker-compose.yml              # تكوين للتطوير
├── docker-compose.prod.yml         # تكوين للإنتاج
├── .dockerignore                   # الملفات المستبعدة
├── docker-setup.sh                 # سكريبت الإعداد التلقائي
├── Makefile                        # اختصارات الأوامر
├── DOCKER_GUIDE.md                 # الدليل الشامل
├── .env.docker.example             # نموذج ملف البيئة
└── docker/
    ├── nginx/
    │   ├── default.conf            # تكوين nginx للتطوير
    │   └── default.ssl.conf        # تكوين nginx مع SSL
    ├── php/
    │   └── local.ini               # تكوين PHP
    ├── mysql/
    │   └── my.cnf                  # تكوين MySQL
    ├── supervisor/
    │   └── supervisord.conf        # تكوين Supervisor
    └── cron/
        └── laravel-cron            # مهام Cron
```

## 🆘 الحصول على المساعدة

```bash
# عرض الأوامر المتاحة
make help

# عرض معلومات النظام
make info

# قراءة الدليل الشامل
cat DOCKER_GUIDE.md
```

## 📝 ملاحظات

- جميع البيانات محفوظة في Docker volumes
- لحذف البيانات نهائياً: `docker-compose down -v`
- للتطوير المحلي: استخدم `docker-compose.yml`
- للإنتاج: استخدم `docker-compose.prod.yml`
- تأكد من تحديث `.env` قبل الإنتاج

---

**تم بنجاح! 🎉 يمكنك الآن البدء في استخدام التطبيق.**
