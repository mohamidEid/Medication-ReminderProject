# استخدام PHP 8.2 FPM كصورة أساسية
FROM php:8.2-fpm

# تعيين متغيرات البيئة
ENV APP_HOME /var/www/html
ENV COMPOSER_ALLOW_SUPERUSER=1

# تثبيت متطلبات النظام
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libpq-dev \
    supervisor \
    cron \
    nginx \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# تثبيت Redis extension
RUN pecl install redis \
    && docker-php-ext-enable redis

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# تثبيت Node.js و npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# تنظيف الملفات المؤقتة
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# إنشاء مجلد التطبيق
WORKDIR $APP_HOME

# نسخ ملفات المشروع
COPY ./server/composer.json ./server/composer.lock* ./
RUN composer install --no-scripts --no-autoloader --prefer-dist

# نسخ باقي ملفات المشروع
COPY ./server .

# إعطاء صلاحيات للمجلدات المطلوبة
RUN chown -R www-data:www-data $APP_HOME \
    && chmod -R 755 $APP_HOME/storage \
    && chmod -R 755 $APP_HOME/bootstrap/cache

# تشغيل Composer autoload
RUN composer dump-autoload --optimize

# تثبيت حزم Node.js وبناء الأصول
RUN npm install && npm run build

# نسخ ملف تكوين Supervisor
COPY ./docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# نسخ ملف crontab
COPY ./docker/cron/laravel-cron /etc/cron.d/laravel-cron
RUN chmod 0644 /etc/cron.d/laravel-cron \
    && crontab /etc/cron.d/laravel-cron

# فتح المنفذ
EXPOSE 9000

# تشغيل Supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
