<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MedicineController;
use App\Http\Controllers\Api\DoseController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\AlertController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\CompanionController;
use App\Http\Controllers\Api\TreatmentPlanController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Medicines
    Route::apiResource('medicines', MedicineController::class)->names([
        'index' => 'api.medicines.index',
        'store' => 'api.medicines.store',
        'show' => 'api.medicines.show',
        'update' => 'api.medicines.update',
        'destroy' => 'api.medicines.destroy',
    ]);

    // Doses
    Route::get('/doses', [DoseController::class, 'index']);
    Route::get('/doses/today', [DoseController::class, 'today']);
    Route::get('/doses/upcoming', [DoseController::class, 'upcoming']);
    Route::get('/doses/stats', [DoseController::class, 'stats']);
    Route::post('/doses/{dose}/taken', [DoseController::class, 'markAsTaken']);
    Route::post('/doses/{dose}/missed', [DoseController::class, 'markAsMissed']);
    Route::post('/doses/{dose}/skipped', [DoseController::class, 'markAsSkipped']);

    // Subscriptions
    Route::get('/subscription', [SubscriptionController::class, 'current']);
    Route::post('/subscription/subscribe', [SubscriptionController::class, 'subscribe']);
    Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel']);

    // Alerts (Smart Features)
    Route::prefix('alerts')->group(function () {
        Route::get('/', [AlertController::class, 'index']);
        Route::get('/unread-count', [AlertController::class, 'unreadCount']);
        Route::post('/{id}/read', [AlertController::class, 'markAsRead']);
        Route::post('/{id}/dismiss', [AlertController::class, 'dismiss']);
        Route::post('/read-all', [AlertController::class, 'markAllAsRead']);
        Route::post('/run-checks', [AlertController::class, 'runChecks']);
    });

    // Inventory (Smart Features)
    Route::prefix('inventory')->group(function () {
        Route::get('/', [InventoryController::class, 'index']);
        Route::get('/low-stock', [InventoryController::class, 'lowStock']);
        Route::post('/check', [InventoryController::class, 'checkLowStock']);
    });

    // Medicine Inventory
    Route::prefix('medicines/{id}')->group(function () {
        Route::get('/inventory', [InventoryController::class, 'show']);
        Route::post('/refill', [InventoryController::class, 'refill']);
        Route::post('/update-quantity', [InventoryController::class, 'updateQuantity']);
    });

    // Companions (Smart Features)
    Route::prefix('companions')->group(function () {
        Route::get('/', [CompanionController::class, 'index']);
        Route::post('/invite', [CompanionController::class, 'invite']);
        Route::post('/{token}/accept', [CompanionController::class, 'accept']);
        Route::post('/{token}/reject', [CompanionController::class, 'reject']);
        Route::put('/{id}/permissions', [CompanionController::class, 'updatePermissions']);
        Route::delete('/{id}', [CompanionController::class, 'destroy']);
        Route::get('/patients', [CompanionController::class, 'patients']);
    });

    // Treatment Plan Sharing (Smart Features)
    Route::prefix('treatment-plan')->group(function () {
        Route::get('/shares', [TreatmentPlanController::class, 'index']);
        Route::post('/share', [TreatmentPlanController::class, 'share']);
        Route::get('/export/pdf', [TreatmentPlanController::class, 'exportPdf']);
        Route::get('/export/excel', [TreatmentPlanController::class, 'exportExcel']);
        Route::post('/shares/{id}/deactivate', [TreatmentPlanController::class, 'deactivate']);
        Route::delete('/shares/{id}', [TreatmentPlanController::class, 'destroy']);
    });
});

// Public route for viewing shared treatment plans
Route::get('/shared/treatment-plan/{token}', [TreatmentPlanController::class, 'view']);

// SMS Test Routes
Route::post('/test/sms', [App\Http\Controllers\Api\NotificationTestController::class, 'testSms']);
Route::post('/test/whatsapp', [App\Http\Controllers\Api\NotificationTestController::class, 'testWhatsApp']);
Route::get('/test/provider-info', [App\Http\Controllers\Api\NotificationTestController::class, 'getProviderInfo']);
Route::post('/test/medicine-reminder', [App\Http\Controllers\Api\NotificationTestController::class, 'testMedicineReminder']);
