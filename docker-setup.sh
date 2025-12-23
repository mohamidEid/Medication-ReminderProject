#!/bin/bash

# ألوان لتحسين العرض
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}  إعداد مشروع Medication Reminder${NC}"
echo -e "${GREEN}========================================${NC}\n"

# التحقق من وجود Docker
if ! command -v docker &> /dev/null; then
    echo -e "${RED}خطأ: Docker غير مثبت. يرجى تثبيت Docker أولاً.${NC}"
    exit 1
fi

if ! command -v docker-compose &> /dev/null; then
    echo -e "${RED}خطأ: Docker Compose غير مثبت. يرجى تثبيت Docker Compose أولاً.${NC}"
    exit 1
fi

# نسخ ملف .env إذا لم يكن موجوداً
echo -e "${YELLOW}1. إعداد ملف البيئة...${NC}"
if [ ! -f server/.env ]; then
    cp server/.env.example server/.env
    echo -e "${GREEN}✓ تم نسخ ملف .env من .env.example${NC}"
else
    echo -e "${GREEN}✓ ملف .env موجود بالفعل${NC}"
fi

# توليد مفتاح التطبيق
echo -e "\n${YELLOW}2. توليد مفتاح التطبيق...${NC}"
docker-compose run --rm app php artisan key:generate
echo -e "${GREEN}✓ تم توليد مفتاح التطبيق${NC}"

# بناء وتشغيل الحاويات
echo -e "\n${YELLOW}3. بناء وتشغيل الحاويات...${NC}"
docker-compose up -d --build
echo -e "${GREEN}✓ تم بناء وتشغيل الحاويات${NC}"

# الانتظار حتى تصبح قاعدة البيانات جاهزة
echo -e "\n${YELLOW}4. انتظار جاهزية قاعدة البيانات...${NC}"
sleep 10

# تشغيل migrations
echo -e "\n${YELLOW}5. تشغيل Database Migrations...${NC}"
docker-compose exec app php artisan migrate --force
echo -e "${GREEN}✓ تم تشغيل Migrations${NC}"

# تشغيل seeders (اختياري)
echo -e "\n${YELLOW}6. هل تريد تشغيل Database Seeders؟ (y/n)${NC}"
read -r response
if [[ "$response" =~ ^([yY][eE][sS]|[yY])$ ]]; then
    docker-compose exec app php artisan db:seed
    echo -e "${GREEN}✓ تم تشغيل Seeders${NC}"
fi

# إنشاء رابط التخزين
echo -e "\n${YELLOW}7. إنشاء رابط التخزين...${NC}"
docker-compose exec app php artisan storage:link
echo -e "${GREEN}✓ تم إنشاء رابط التخزين${NC}"

# تحسين الأداء
echo -e "\n${YELLOW}8. تحسين الأداء...${NC}"
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache
echo -e "${GREEN}✓ تم تحسين الأداء${NC}"

# إنشاء مستخدم admin (Filament)
echo -e "\n${YELLOW}9. هل تريد إنشاء مستخدم admin؟ (y/n)${NC}"
read -r admin_response
if [[ "$admin_response" =~ ^([yY][eE][sS]|[yY])$ ]]; then
    docker-compose exec app php artisan make:filament-user
fi

echo -e "\n${GREEN}========================================${NC}"
echo -e "${GREEN}  ✓ تم الإعداد بنجاح!${NC}"
echo -e "${GREEN}========================================${NC}"
echo -e "\n${YELLOW}التطبيق يعمل الآن على:${NC}"
echo -e "  - التطبيق الرئيسي: ${GREEN}http://localhost${NC}"
echo -e "  - لوحة Filament: ${GREEN}http://localhost/admin${NC}"
echo -e "  - phpMyAdmin: ${GREEN}http://localhost:8080${NC}"
echo -e "\n${YELLOW}الأوامر المفيدة:${NC}"
echo -e "  - إيقاف الحاويات: ${GREEN}docker-compose down${NC}"
echo -e "  - مشاهدة السجلات: ${GREEN}docker-compose logs -f${NC}"
echo -e "  - تشغيل أمر Laravel: ${GREEN}docker-compose exec app php artisan [command]${NC}"
echo -e ""
