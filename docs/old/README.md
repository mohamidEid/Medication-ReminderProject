# 💊 MediRemind - نظام إدارة الأدوية الذكي

<div align="center">

![MediRemind Logo](https://img.shields.io/badge/MediRemind-Smart%20Medicine%20Manager-667eea?style=for-the-badge&logo=medical-cross)

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat-square&logo=laravel)](https://laravel.com)
[![Filament](https://img.shields.io/badge/Filament-4.x-F59E0B?style=flat-square)](https://filamentphp.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=flat-square)](LICENSE)

**نظام ذكي شامل لإدارة الأدوية والجرعات مع تذكيرات تلقائية عبر WhatsApp و SMS**

[المميزات](#-المميزات) • [التثبيت](#️-التثبيت) • [الاستخدام](#-الاستخدام) • [API](#-api-documentation) • [المساهمة](#-المساهمة)

</div>

---

## 📋 نظرة عامة

**MediRemind** هو نظام إدارة أدوية متكامل مبني بـ Laravel، يساعد المستخدمين على تتبع أدويتهم، جدولة الجرعات، واستلام تذكيرات تلقائية عبر WhatsApp و SMS و Push Notifications.

### 🎯 المشكلة التي نحلها

- **نسيان تناول الأدوية** في المواعيد المحددة
- **صعوبة تتبع** الأدوية المتعددة
- **نفاد المخزون** بدون إشعار مسبق
- **عدم وجود سجل دقيق** للجرعات المأخوذة

### ✨ الحل

نظام ذكي شامل يوفر:
- ⏰ تذكيرات تلقائية عبر WhatsApp, SMS, Push Notifications
- 📊 تحليلات ذكية ومتابعة دقيقة
- 👥 مشاركة البيانات مع أفراد العائلة
- 📱 واجهة سهلة الاستخدام

---

## ⭐ المميزات

### 🔔 نظام التذكيرات المتقدم
- ✅ إشعارات WhatsApp تلقائية
- ✅ رسائل SMS
- ✅ Push Notifications
- ✅ جدولة ذكية للجرعات
- ✅ تذكيرات قبل نفاد المخزون

### 📊 المميزات الذكية (Smart Features)
- 🚨 **تنبيهات ذكية**: تحذيرات عند نسيان الجرعة أو تأخرها
- 📦 **إدارة المخزون**: تتبع كمية الأدوية المتبقية
- 👥 **المرافقين**: إضافة أفراد العائلة لمتابعة العلاج
- 📄 **مشاركة خطة العلاج**: تصدير و مشاركة خطة العلاج PDF/Excel
- 📈 **تحليلات سلوكية**: تحليل أنماط تناول الدواء

### 🎛️ لوحة تحكم Filament
- ✅ إدارة كاملة للمستخدمين
- ✅ إدارة الأدوية والجرعات
- ✅ نظام الاشتراكات والإيصالات
- ✅ تقارير وإحصائيات شاملة
- ✅ نظام صلاحيات متقدم (Spatie Permission)

### 💳 نظام الاشتراكات
- ✅ باقات متعددة (Free, Pro, Family)
- ✅ معالجة الدفع (Vodafone Cash)
- ✅ إيصالات PDF احترافية
- ✅ موافقة تلقائية أو يدوية

### 🔐 الأمان والصلاحيات
- ✅ نظام صلاحيات متقدم (3 أدوار: Super Admin, Admin, User)
- ✅ حماية API بـ Laravel Sanctum
- ✅ التحقق من الصلاحيات على مستوى الموارد

---

## 🛠️ التقنيات المستخدمة

### Backend
- **Laravel 11.x** - PHP Framework
- **Filament 4.x** - Admin Panel
- **MySQL** - Database
- **Redis** - Cache & Queue
- **Laravel Sanctum** - API Authentication
- **Spatie Permission** - Role & Permission Management

### Frontend
- **Blade Templates** - Server-side rendering
- **Tailwind CSS** - Styling
- **Alpine.js** - Interactive components
- **Livewire** - Real-time updates

### Integrations
- **Twilio** - SMS & WhatsApp notifications
- **DomPDF** - PDF generation
- **Laravel Queue** - Background jobs

### DevOps
- **Docker** - Containerization
- **Docker Compose** - Multi-container orchestration
- **Nginx** - Web server
- **Supervisor** - Process management

---

## 🚀 التثبيت

### المتطلبات

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL >= 8.0
- Redis (اختياري)

### طريقة 1: التثبيت المباشر

```bash
# Clone the repository
git clone https://github.com/yourusername/mediremind.git
cd mediremind/server

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure database in .env
DB_DATABASE=mediremind
DB_USERNAME=root
DB_PASSWORD=

# Run migrations
php artisan migrate --seed

# Link storage
php artisan storage:link

# Build assets
npm run build

# Start the server
php artisan serve
```

### طريقة 2: باستخدام Docker (موصى به)

```bash
# Clone the repository
git clone https://github.com/yourusername/mediremind.git
cd mediremind

# Make setup script executable
chmod +x docker-setup.sh

# Run setup
./docker-setup.sh

# Access the application
http://localhost:8000
```

للمزيد من التفاصيل، راجع [DOCKER_GUIDE.md](DOCKER_GUIDE.md)

---

### الوصول للوحة التحكم

افتح المتصفح وانتقل إلى:
```
http://localhost:8000/admin
```

### الصفحات الرئيسية

- **الصفحة الرئيسية**: `http://localhost:8000`
- **لوحة التحكم**: `http://localhost:8000/dashboard`
- **الأدوية**: `http://localhost:8000/medicines`
- **المميزات الذكية**: `http://localhost:8000/smart-features`
- **المرافقين**: `http://localhost:8000/companions`
- **الاشتراك**: `http://localhost:8000/subscription`

---

## 🔌 API Documentation

### Authentication

جميع API endpoints تتطلب authentication عبر Laravel Sanctum:

```http
Authorization: Bearer {token}
```

### Endpoints الرئيسية

#### Medicines
```http
GET    /api/medicines          # Get all medicines
POST   /api/medicines          # Create medicine
GET    /api/medicines/{id}     # Get single medicine
PUT    /api/medicines/{id}     # Update medicine
DELETE /api/medicines/{id}     # Delete medicine
```

#### Doses
```http
GET    /api/doses              # Get all doses
POST   /api/doses              # Create dose
GET    /api/doses/today        # Today's doses
PUT    /api/doses/{id}/take    # Mark as taken
```

#### Smart Features
```http
GET    /api/alerts             # Get alerts
POST   /api/alerts/run-checks  # Run smart checks
POST   /api/alerts/{id}/read   # Mark alert as read

GET    /api/inventory          # Get inventory status
POST   /api/inventory/check    # Check low stock
```

#### Companions
```http
GET    /api/companions         # Get companions
POST   /api/companions/invite  # Invite companion
POST   /api/companions/{id}/accept   # Accept invitation
DELETE /api/companions/{id}    # Remove companion
```

---

## 📁 هيكل المشروع

```
mediremind/
├── server/                      # Laravel Application
│   ├── app/
│   │   ├── Filament/           # Filament Resources
│   │   ├── Http/
│   │   │   └── Controllers/    # API & Web Controllers
│   │   ├── Models/             # Eloquent Models
│   │   └── Services/           # Business Logic
│   ├── database/
│   │   ├── migrations/         # Database Migrations
│   │   └── seeders/           # Data Seeders
│   ├── resources/
│   │   └── views/             # Blade Templates
│   └── routes/
│       ├── api.php            # API Routes
│       └── web.php            # Web Routes
├── docker/                     # Docker Configuration
├── docker-compose.yml
└── README.md
```

---
## 📝 الترخيص

هذا المشروع مرخص تحت [MIT License](LICENSE)

---

## 📞 التواصل

- **Email**: ydm07652@gmail.com
- **WhatsApp**: +20 102 793 1470
- **Phone**: 01027931470

---
