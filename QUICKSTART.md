# 🚀 Quick Start Guide - MediRemind

**Get started in 5 minutes!**

---

## ⚡ Installation

```bash
# 1. Clone
git clone https://github.com/mohamidEid/Medication-ReminderProject.git
cd Medication-ReminderProject/server

# 2. Install Dependencies
composer install
npm install

# 3. Environment
cp .env.example .env
php artisan key:generate

# 4. Configure .env
# Update these:
DB_CONNECTION=pgsql
DB_DATABASE=mediremind
DB_USERNAME=your_user
DB_PASSWORD=your_pass

# 5. Database
php artisan migrate
php artisan db:seed

# 6. Create Admin
php artisan tinker
>>> $user = User::create(['name'=>'Admin', 'email'=>'admin@mediremind.com', 'password'=>bcrypt('admin123'), 'phone'=>'+201234567890']);
>>> $user->assignRole('super_admin');

# 7. Run
php artisan serve
```

**🎉 Done! Visit:** http://localhost:8000

---

## 🔑 Default Logins

### Admin Panel
- URL: http://localhost:8000/admin
- Email: `admin@mediremind.com`
- Password: `admin123`

### Test User
- URL: http://localhost:8000/login
- Email: `test@mediremind.com`
- Password: `password123`

---

## 📖 Full Documentation

- **README.md** - Complete guide
- **ARCHITECTURE.md** - Technical details
- **ISSUES.md** - Troubleshooting
- **FINAL_SUMMARY.md** - Project overview

---

## 💡 Quick Tips

### Testing SMS
1. Go to: http://localhost:8000/admin/sms-test
2. Configure Twilio in `.env`
3. Send test message

### Approving Subscriptions
1. Admin → طلبات الاشتراك
2. Click "موافقة"
3. User subscription activated

### Reminders
```bash
# Start scheduler
php artisan schedule:work
```

---

**Need help?** → ydm07652@gmail.com
