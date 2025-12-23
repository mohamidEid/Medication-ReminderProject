<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    if (Illuminate\Support\Facades\Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    if (Illuminate\Support\Facades\Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.register');
})->name('register');

// Auth Routes
Route::post('/register', function (Illuminate\Http\Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|confirmed|min:8',
    ]);

    $user = App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Illuminate\Support\Facades\Hash::make($request->password),
    ]);

    Illuminate\Support\Facades\Auth::login($user);

    return redirect('/dashboard');
});

Route::post('/login', function (Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Illuminate\Support\Facades\Auth::attempt($credentials, $request->remember)) {
        $request->session()->regenerate();
        return redirect()->intended('dashboard');
    }

    return back()->withErrors([
        'email' => 'بيانات الدخول غير صحيحة.',
    ]);
});

Route::post('/logout', function (Illuminate\Http\Request $request) {
    Illuminate\Support\Facades\Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::resource('medicines', App\Http\Controllers\MedicineController::class)
    ->middleware(['auth'])
    ->names([
        'index' => 'medicines.index',
        'create' => 'medicines.create',
        'store' => 'medicines.store',
        'show' => 'medicines.show',
        'edit' => 'medicines.edit',
        'update' => 'medicines.update',
        'destroy' => 'medicines.destroy',
    ]);

// Magic Login for Debugging
Route::get('/magic-login', function () {
    $user = App\Models\User::firstOrCreate(
        ['email' => 'magic@app.com'],
        [
            'name' => 'Magic User',
            'password' => bcrypt('Super$trong!P@ss2025'),
            'email_verified_at' => now(),
        ]
    );

    Illuminate\Support\Facades\Auth::login($user, true); // true = Remember me
    request()->session()->regenerate();

    return redirect()->route('dashboard');
});

// Password Reset Routes (Added Back)
Route::get('/forgot-password', function () {
    return abort(404, 'Not Implemented Yet');
})->name('password.request');



// --- Session Debugging Routes ---
Route::get('/test-set', function () {
    session(['my_test_var' => 'Session Works! Time: ' . now()]);
    return 'Session value SET. <br><a href="/test-get">Click here to READ session</a>';
});

Route::get('/test-get', function () {
    $val = session('my_test_var', 'Session Missing ❌');
    $id = session()->getId();
    $cookieName = config('session.cookie');
    return "Session Value: <strong>$val</strong><br>Session ID: $id<br>Cookie Name: $cookieName";
});
// --------------------------------

// Settings Routes
Route::get('/settings', function () {
    return view('settings');
})->middleware(['auth'])->name('settings');

Route::put('/settings/profile', function () {
    // TODO: Implement profile update logic
    return back()->with('status', 'تم تحديث الملف الشخصي بنجاح');
})->middleware(['auth'])->name('settings.update-profile');

Route::put('/settings/notifications', function () {
    // TODO: Implement notifications settings logic
    return back()->with('status', 'تم تحديث إعدادات الإشعارات بنجاح');
})->middleware(['auth'])->name('settings.update-notifications');

Route::put('/settings/password', function () {
    // TODO: Implement password update logic
    return back()->with('status', 'تم تحديث كلمة المرور بنجاح');
})->middleware(['auth'])->name('settings.update-password');

// History Route
Route::get('/history', function () {
    return view('history');
})->middleware(['auth'])->name('history');

// Schedule Route
Route::get('/schedule', function () {
    return view('schedule');
})->middleware(['auth'])->name('schedule');

// Smart Features Route
Route::get('/smart-features', function () {
    return view('smart-features');
})->middleware(['auth'])->name('smart-features');

// Companions Route
Route::get('/companions', function () {
    return view('companions');
})->middleware(['auth'])->name('companions');

// Subscription Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/subscription', function () {
        return view('subscription.create');
    })->name('subscription.create');

    Route::post('/subscription', [App\Http\Controllers\SubscriptionController::class, 'submit'])->name('subscription.submit');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/subscriptions', [App\Http\Controllers\Admin\AdminController::class, 'subscriptions'])->name('subscriptions');
    Route::post('/subscriptions/{receipt}/approve', [App\Http\Controllers\Admin\AdminController::class, 'approve'])->name('subscriptions.approve');
    Route::post('/subscriptions/{receipt}/reject', [App\Http\Controllers\Admin\AdminController::class, 'reject'])->name('subscriptions.reject');
    Route::get('/users', [App\Http\Controllers\Admin\AdminController::class, 'users'])->name('users');
});

// Receipt PDF Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/receipts/{id}', [App\Http\Controllers\ReceiptController::class, 'show'])->name('receipts.show');
    Route::get('/receipts/{id}/pdf', [App\Http\Controllers\ReceiptController::class, 'viewPdf'])->name('receipts.pdf');
    Route::get('/receipts/{id}/print', [App\Http\Controllers\ReceiptController::class, 'print'])->name('receipts.print');
    Route::get('/receipts/{id}/download', [App\Http\Controllers\ReceiptController::class, 'downloadPdf'])->name('receipts.download');
});
