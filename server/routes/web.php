<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\Admin\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| Clean routes pointing to controllers only - no business logic here!
|
*/

// ============================================
// Public Routes
// ============================================

Route::get('/', [PageController::class, 'welcome'])->name('home');

// ============================================
// Authentication Routes
// ============================================

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Password Reset (TODO: Implement later)
Route::get('/forgot-password', function () {
    return abort(404, 'Not Implemented Yet');
})->name('password.request');

// ============================================
// Authenticated User Routes
// ============================================

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');

    // Medicines Management (Premium Feature)
    Route::middleware('subscription')->group(function () {
        Route::resource('medicines', MedicineController::class);
    });

    // Schedule & History (Premium Features)
    Route::middleware('subscription')->group(function () {
        Route::get('/schedule', [PageController::class, 'schedule'])->name('schedule');
        Route::get('/history', [PageController::class, 'history'])->name('history');
    });

    // Smart Features & Companions (Premium Features)
    Route::middleware('subscription')->group(function () {
        Route::get('/smart-features', [PageController::class, 'smartFeatures'])->name('smart-features');
        Route::get('/companions', [PageController::class, 'companions'])->name('companions');
    });

    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::put('/profile', [SettingsController::class, 'updateProfile'])->name('update-profile');
        Route::put('/notifications', [SettingsController::class, 'updateNotifications'])->name('update-notifications');
        Route::put('/password', [SettingsController::class, 'updatePassword'])->name('update-password');
    });

    // Subscription
    Route::prefix('subscription')->name('subscription.')->group(function () {
        Route::get('/', [SubscriptionController::class, 'create'])->name('create');
        Route::post('/', [SubscriptionController::class, 'submit'])->name('submit');
    });

    // Receipt PDF
    Route::prefix('receipts')->name('receipts.')->group(function () {
        Route::get('/{id}', [ReceiptController::class, 'show'])->name('show');
        Route::get('/{id}/pdf', [ReceiptController::class, 'viewPdf'])->name('pdf');
        Route::get('/{id}/print', [ReceiptController::class, 'print'])->name('print');
        Route::get('/{id}/download', [ReceiptController::class, 'downloadPdf'])->name('download');
    });

    // SMS Test
    Route::get('/sms-test', [PageController::class, 'smsTest'])->name('sms.test');
});

// ============================================
// Admin Routes (Old - kept for compatibility)
// ============================================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/subscriptions', [AdminController::class, 'subscriptions'])->name('subscriptions');
    Route::post('/subscriptions/{receipt}/approve', [AdminController::class, 'approve'])->name('subscriptions.approve');
    Route::post('/subscriptions/{receipt}/reject', [AdminController::class, 'reject'])->name('subscriptions.reject');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
});

// ============================================
// Development & Testing Routes (REMOVED FOR PRODUCTION)
// ============================================

// All development routes have been removed for production security
// If needed in development, uncomment the routes below

/*
if (app()->environment(['local', 'development'])) {
    Route::get('/magic-login', function () { ... });
    Route::get('/test-set', function () { ... });
    Route::get('/test-get', function () { ... });
}
*/
