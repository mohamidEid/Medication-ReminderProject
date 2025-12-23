<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Companion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class CompanionController extends Controller
{
    /**
     * Get all companions for authenticated user
     */
    public function index(Request $request)
    {
        $companions = Companion::where('patient_id', $request->user()->id)
            ->orWhere('companion_id', $request->user()->id)
            ->with(['patient', 'companion'])
            ->get();

        return response()->json([
            'success' => true,
            'data' => $companions,
        ]);
    }

    /**
     * Invite a companion
     */
    public function invite(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'relationship' => 'nullable|string',
            'permissions' => 'nullable|array',
        ]);

        $companion = User::where('email', $request->email)->firstOrFail();

        // Check if already exists
        $existing = Companion::where('patient_id', $request->user()->id)
            ->where('companion_id', $companion->id)
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'هذا المرافق مضاف بالفعل',
            ], 400);
        }

        // Create invitation
        $invitation = Companion::create([
            'patient_id' => $request->user()->id,
            'companion_id' => $companion->id,
            'relationship' => $request->relationship,
            'permissions' => $request->permissions ?? ['view_medications', 'view_doses'],
            'status' => 'pending',
            'invitation_token' => Str::random(32),
            'invitation_sent_at' => now(),
        ]);

        // TODO: Send email notification

        return response()->json([
            'success' => true,
            'message' => 'تم إرسال الدعوة بنجاح',
            'data' => $invitation,
        ]);
    }

    /**
     * Accept companion invitation
     */
    public function accept($token)
    {
        $companion = Companion::where('invitation_token', $token)
            ->where('companion_id', auth()->id())
            ->where('status', 'pending')
            ->firstOrFail();

        $companion->update([
            'status' => 'accepted',
            'invitation_accepted_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم قبول الدعوة بنجاح',
            'data' => $companion,
        ]);
    }

    /**
     * Reject companion invitation
     */
    public function reject($token)
    {
        $companion = Companion::where('invitation_token', $token)
            ->where('companion_id', auth()->id())
            ->where('status', 'pending')
            ->firstOrFail();

        $companion->update([
            'status' => 'rejected',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم رفض الدعوة',
        ]);
    }

    /**
     * Update companion permissions
     */
    public function updatePermissions(Request $request, $id)
    {
        $request->validate([
            'permissions' => 'required|array',
        ]);

        $companion = Companion::where('patient_id', auth()->id())
            ->findOrFail($id);

        $companion->update([
            'permissions' => $request->permissions,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الصلاحيات',
            'data' => $companion,
        ]);
    }

    /**
     * Remove companion
     */
    public function destroy($id)
    {
        $companion = Companion::where('patient_id', auth()->id())
            ->orWhere('companion_id', auth()->id())
            ->findOrFail($id);

        $companion->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم إزالة المرافق',
        ]);
    }

    /**
     * Get patients (for companions)
     */
    public function patients(Request $request)
    {
        $patients = Companion::where('companion_id', $request->user()->id)
            ->accepted()
            ->with('patient')
            ->get()
            ->pluck('patient');

        return response()->json([
            'success' => true,
            'data' => $patients,
        ]);
    }
}
