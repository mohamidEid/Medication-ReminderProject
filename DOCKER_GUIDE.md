# دليل Docker للمشروع

## المتطلبات الأساسية

- Docker >= 20.10
- Docker Compose >= 2.0

## الخدمات المتوفرة

يحتوي المشروع على الخدمات التالية:

1. **app**: تطبيق Laravel (PHP 8.2-FPM)
2. **nginx**: خادم الويب Nginx
3. **mysql**: قاعدة بيانات MySQL 8.0
4. **redis**: قاعدة بيانات Redis للتخزين المؤقت
5. **queue**: معالج الطوابير (Queue Worker)
6. **scheduler**: مجدول المهام (Task Scheduler)
7. **phpmyadmin**: واجهة إدارة قاعدة البيانات

## التثبيت السريع

### 1. الإعداد التلقائي (موصى به)

```bash
chmod +x docker-setup.sh
./docker-setup.sh
```

### 2. الإعداد اليدوي

```bash
# نسخ ملف البيئة
cp server/.env.example server/.env

# بناء وتشغيل الحاويات
docker-compose up -d --build

# توليد مفتاح التطبيق
docker-compose exec app php artisan key:generate

# تشغيل migrations
docker-compose exec app php artisan migrate --force

# تشغيل seeders (اختياري)
docker-compose exec app php artisan db:seed

# إنشاء رابط التخزين
docker-compose exec app php artisan storage:link

# تحسين الأداء
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache
```

## الوصول إلى التطبيق

- **التطبيق الرئيسي**: http://localhost
- **لوحة Filament Admin**: http://localhost/admin
- **phpMyAdmin**: http://localhost:8080

## الأوامر المفيدة

### إدارة الحاويات

```bash
# تشغيل الحاويات
docker-compose up -d

# إيقاف الحاويات
docker-compose down

# إيقاف الحاويات مع حذف البيانات
docker-compose down -v

# إعادة بناء الحاويات
docker-compose up -d --build

# مشاهدة السجلات
docker-compose logs -f

# مشاهدة سجلات خدمة معينة
docker-compose logs -f app
```

### تشغيل أوامر Laravel

```bash
# تشغيل أمر artisan
docker-compose exec app php artisan [command]

# تشغيل migrations
docker-compose exec app php artisan migrate

# إنشاء مستخدم Filament admin
docker-compose exec app php artisan make:filament-user

# مسح الـ cache
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear

# تشغيل composer
docker-compose exec app composer [command]

# تشغيل npm
docker-compose exec app npm [command]
```

### الوصول إلى shell الحاوية

```bash
# الدخول إلى حاوية التطبيق
docker-compose exec app bash

# الدخول إلى MySQL
docker-compose exec mysql mysql -u medication_user -p medication_db
# كلمة المرور: medication_password

# الدخول إلى Redis CLI
docker-compose exec redis redis-cli
```

## إعدادات قاعدة البيانات

### بيانات الاتصال

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=medication_db
DB_USERNAME=medication_user
DB_PASSWORD=medication_password
```

### الوصول من خارج Docker

```env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=medication_db
DB_USERNAME=medication_user
DB_PASSWORD=medication_password
```

## إعدادات Redis

```env
REDIS_HOST=redis
REDIS_PORT=6379
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis
```

## استكشاف الأخطاء

### مشكلة الأذونات

```bash
# إعطاء الأذونات المناسبة
docker-compose exec app chown -R www-data:www-data /var/www/html/storage
docker-compose exec app chmod -R 755 /var/www/html/storage
```

### مشكلة في قاعدة البيانات

```bash
# إعادة تشغيل MySQL
docker-compose restart mysql

# التحقق من حالة MySQL
docker-compose exec mysql mysql -u root -p -e "SELECT 1"
```

### مشكلة في Queue Worker

```bash
# إعادة تشغيل Queue Worker
docker-compose restart queue

# مشاهدة سجلات Queue
docker-compose logs -f queue
```

### تنظيف كامل وإعادة البناء

```bash
# إيقاف وحذف كل شيء
docker-compose down -v

# حذف الصور
docker-compose down --rmi all

# إعادة البناء من الصفر
docker-compose up -d --build --force-recreate
```

## البيئة الإنتاجية

### تحديث ملف .env

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# استخدام HTTPS
HTTPS=true
```

### تفعيل SSL (اختياري)

1. ضع شهادات SSL في `docker/nginx/ssl/`
2. قم بتحديث ملف `docker/nginx/default.conf` لدعم HTTPS

### تحسين الأداء

```bash
# تحسين composer للإنتاج
docker-compose exec app composer install --optimize-autoloader --no-dev

# تحسين Laravel
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache
docker-compose exec app php artisan event:cache
```

## النسخ الاحتياطي

### قاعدة البيانات

```bash
# إنشاء نسخة احتياطية
docker-compose exec mysql mysqldump -u medication_user -pmedication_password medication_db > backup.sql

# استعادة من نسخة احتياطية
docker-compose exec -T mysql mysql -u medication_user -pmedication_password medication_db < backup.sql
```

### الملفات

```bash
# نسخ احتياطي للتخزين
tar -czf storage-backup.tar.gz server/storage/app
```

## الملاحظات

- جميع البيانات المخزنة في volumes سيتم الاحتفاظ بها حتى بعد إيقاف الحاويات
- للتطوير المحلي، يمكنك استخدام `sync` volumes لتحديث الكود مباشرة
- تأكد من تحديث كلمات المرور في البيئة الإنتاجية

## الدعم

للمزيد من المعلومات، راجع:
- [وثائق Docker](https://docs.docker.com/)
- [وثائق Laravel](https://laravel.com/docs)
- [وثائق Filament](https://filamentphp.com/docs)
