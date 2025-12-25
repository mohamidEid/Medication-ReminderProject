<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

/**
 * Settings Controller
 *
 * Handles user settings and preferences
 */
class SettingsController extends Controller
{
    /**
     * Show settings page
     */
    public function index(): View
    {
        return view('settings');
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . auth()->id()],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        auth()->user()->update($validated);

        return back()->with('status', 'تم تحديث الملف الشخصي بنجاح');
    }

    /**
     * Update notification settings
     */
    public function updateNotifications(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'sms_notifications' => ['boolean'],
            'whatsapp_notifications' => ['boolean'],
            'email_notifications' => ['boolean'],
        ]);

        // TODO: Save to user preferences table
        // For now, just return success

        return back()->with('status', 'تم تحديث إعدادات الإشعارات بنجاح');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        auth()->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'تم تحديث كلمة المرور بنجاح');
    }
}
