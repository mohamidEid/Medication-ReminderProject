<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        // Create free subscription for new user
        Subscription::create([
            'user_id' => $user->id,
            'plan_type' => 'free',
            'status' => 'active',
            'start_date' => now(),
            'amount' => 0,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'subscription' => [
                'plan' => 'free',
                'status' => 'active'
            ]
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        $subscription = $user->activeSubscription;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'subscription' => $subscription ? [
                'plan' => $subscription->plan_type,
                'status' => $subscription->status,
                'end_date' => $subscription->end_date
            ] : [
                'plan' => 'free',
                'status' => 'active'
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    public function user(Request $request)
    {
        $user = $request->user();
        $subscription = $user->activeSubscription;

        return response()->json([
            'user' => $user,
            'subscription' => $subscription ? [
                'plan' => $subscription->plan_type,
                'status' => $subscription->status,
                'end_date' => $subscription->end_date
            ] : [
                'plan' => 'free',
                'status' => 'active'
            ]
        ]);
    }
}
