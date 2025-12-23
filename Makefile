.PHONY: help build up down restart logs shell mysql redis clean install migrate seed cache

# الألوان للإخراج
GREEN  := $(shell tput -Txterm setaf 2)
YELLOW := $(shell tput -Txterm setaf 3)
WHITE  := $(shell tput -Txterm setaf 7)
RESET  := $(shell tput -Txterm sgr0)

# المساعدة الافتراضية
help: ## عرض هذه المساعدة
	@echo '${YELLOW}الأوامر المتاحة:${RESET}'
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  ${GREEN}%-15s${RESET} %s\n", $$1, $$2}'

# أوامر Docker
build: ## بناء الحاويات
	@echo "${YELLOW}بناء الحاويات...${RESET}"
	docker-compose build
	@echo "${GREEN}✓ تم بناء الحاويات بنجاح${RESET}"

up: ## تشغيل الحاويات
	@echo "${YELLOW}تشغيل الحاويات...${RESET}"
	docker-compose up -d
	@echo "${GREEN}✓ الحاويات تعمل الآن${RESET}"

down: ## إيقاف الحاويات
	@echo "${YELLOW}إيقاف الحاويات...${RESET}"
	docker-compose down
	@echo "${GREEN}✓ تم إيقاف الحاويات${RESET}"

restart: ## إعادة تشغيل الحاويات
	@echo "${YELLOW}إعادة تشغيل الحاويات...${RESET}"
	docker-compose restart
	@echo "${GREEN}✓ تم إعادة تشغيل الحاويات${RESET}"

logs: ## عرض سجلات الحاويات
	docker-compose logs -f

ps: ## عرض حالة الحاويات
	docker-compose ps

# أوامر Shell
shell: ## الدخول إلى shell التطبيق
	docker-compose exec app bash

mysql: ## الدخول إلى MySQL shell
	docker-compose exec mysql mysql -u medication_user -pmedication_password medication_db

redis: ## الدخول إلى Redis CLI
	docker-compose exec redis redis-cli

# التنظيف
clean: ## تنظيف الحاويات والـ volumes
	@echo "${YELLOW}تنظيف الحاويات...${RESET}"
	docker-compose down -v
	@echo "${GREEN}✓ تم التنظيف${RESET}"

clean-all: ## تنظيف كامل مع حذف الصور
	@echo "${YELLOW}تنظيف كامل...${RESET}"
	docker-compose down -v --rmi all
	@echo "${GREEN}✓ تم التنظيف الكامل${RESET}"

# إعداد التطبيق
install: ## تثبيت التطبيق (setup كامل)
	@chmod +x docker-setup.sh
	@./docker-setup.sh

# أوامر Laravel
migrate: ## تشغيل database migrations
	docker-compose exec app php artisan migrate

migrate-fresh: ## تشغيل migrations من الصفر
	docker-compose exec app php artisan migrate:fresh

seed: ## تشغيل database seeders
	docker-compose exec app php artisan db:seed

migrate-seed: ## تشغيل migrations و seeders
	docker-compose exec app php artisan migrate --seed

# التخزين المؤقت
cache: ## تخزين التكوينات مؤقتاً
	@echo "${YELLOW}تخزين التكوينات...${RESET}"
	docker-compose exec app php artisan config:cache
	docker-compose exec app php artisan route:cache
	docker-compose exec app php artisan view:cache
	@echo "${GREEN}✓ تم التخزين المؤقت${RESET}"

cache-clear: ## مسح التخزين المؤقت
	@echo "${YELLOW}مسح التخزين المؤقت...${RESET}"
	docker-compose exec app php artisan cache:clear
	docker-compose exec app php artisan config:clear
	docker-compose exec app php artisan route:clear
	docker-compose exec app php artisan view:clear
	@echo "${GREEN}✓ تم مسح التخزين المؤقت${RESET}"

# Composer & NPM
composer-install: ## تثبيت حزم Composer
	docker-compose exec app composer install

composer-update: ## تحديث حزم Composer
	docker-compose exec app composer update

npm-install: ## تثبيت حزم NPM
	docker-compose exec app npm install

npm-build: ## بناء أصول NPM
	docker-compose exec app npm run build

npm-dev: ## بناء أصول NPM للتطوير
	docker-compose exec app npm run dev

# الاختبارات
test: ## تشغيل الاختبارات
	docker-compose exec app php artisan test

test-coverage: ## تشغيل الاختبارات مع التغطية
	docker-compose exec app php artisan test --coverage

# الأذونات
permissions: ## إصلاح أذونات الملفات
	@echo "${YELLOW}إصلاح الأذونات...${RESET}"
	docker-compose exec app chown -R www-data:www-data /var/www/html/storage
	docker-compose exec app chmod -R 755 /var/www/html/storage
	docker-compose exec app chmod -R 755 /var/www/html/bootstrap/cache
	@echo "${GREEN}✓ تم إصلاح الأذونات${RESET}"

# النسخ الاحتياطي
backup-db: ## نسخ احتياطي لقاعدة البيانات
	@echo "${YELLOW}إنشاء نسخة احتياطية...${RESET}"
	docker-compose exec mysql mysqldump -u medication_user -pmedication_password medication_db > backup-$(shell date +%Y%m%d-%H%M%S).sql
	@echo "${GREEN}✓ تم إنشاء النسخة الاحتياطية${RESET}"

restore-db: ## استعادة قاعدة البيانات (استخدم: make restore-db FILE=backup.sql)
	@if [ -z "$(FILE)" ]; then echo "${YELLOW}استخدم: make restore-db FILE=backup.sql${RESET}"; exit 1; fi
	@echo "${YELLOW}استعادة قاعدة البيانات...${RESET}"
	docker-compose exec -T mysql mysql -u medication_user -pmedication_password medication_db < $(FILE)
	@echo "${GREEN}✓ تم استعادة قاعدة البيانات${RESET}"

# الإنتاج
deploy: ## نشر التطبيق (production)
	@echo "${YELLOW}نشر التطبيق للإنتاج...${RESET}"
	docker-compose -f docker-compose.prod.yml up -d --build
	docker-compose -f docker-compose.prod.yml exec app php artisan migrate --force
	docker-compose -f docker-compose.prod.yml exec app php artisan config:cache
	docker-compose -f docker-compose.prod.yml exec app php artisan route:cache
	docker-compose -f docker-compose.prod.yml exec app php artisan view:cache
	@echo "${GREEN}✓ تم النشر بنجاح${RESET}"

# معلومات
info: ## عرض معلومات النظام
	@echo "${YELLOW}معلومات النظام:${RESET}"
	@echo "Docker version: $(shell docker --version)"
	@echo "Docker Compose version: $(shell docker-compose --version)"
	@echo ""
	@echo "${YELLOW}الحاويات قيد التشغيل:${RESET}"
	@docker-compose ps

# الافتراضي
.DEFAULT_GOAL := help
