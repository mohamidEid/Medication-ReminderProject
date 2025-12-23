<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TreatmentPlanShare;
use App\Models\Medicine;
use App\Models\Dose;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TreatmentPlanController extends Controller
{
    /**
     * Create share link for treatment plan
     */
    public function share(Request $request)
    {
        $request->validate([
            'recipient_email' => 'nullable|email',
            'recipient_name' => 'nullable|string',
            'format' => 'nullable|in:pdf,excel,json,web',
            'notes' => 'nullable|string',
            'expires_days' => 'nullable|integer|min:1|max:90',
        ]);

        $share = TreatmentPlanShare::create([
            'user_id' => $request->user()->id,
            'token' => Str::random(32),
            'recipient_email' => $request->recipient_email,
            'recipient_name' => $request->recipient_name,
            'format' => $request->format ?? 'web',
            'notes' => $request->notes,
            'expires_at' => $request->expires_days
                ? now()->addDays($request->expires_days)
                : now()->addDays(7), // Default 7 days
            'is_active' => true,
        ]);

        $shareUrl = url("/shared/treatment-plan/{$share->token}");

        return response()->json([
            'success' => true,
            'message' => 'تم إنشاء رابط المشاركة',
            'data' => [
                'share' => $share,
                'url' => $shareUrl,
            ],
        ]);
    }

    /**
     * View shared treatment plan
     */
    public function view($token)
    {
        $share = TreatmentPlanShare::where('token', $token)
            ->where('is_active', true)
            ->where(function($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->firstOrFail();

        // Increment view count
        $share->increment('views_count');
        $share->update(['last_viewed_at' => now()]);

        // Get treatment plan data
        $medicines = Medicine::where('user_id', $share->user_id)
            ->with(['doses' => function($query) {
                $query->where('scheduled_time', '>=', now()->subDays(30))
                    ->orderBy('scheduled_time', 'desc')
                    ->limit(100);
            }])
            ->get();

        $data = [
            'share_info' => [
                'created_at' => $share->created_at,
                'expires_at' => $share->expires_at,
                'notes' => $share->notes,
                'recipient_name' => $share->recipient_name,
            ],
            'patient' => [
                'name' => $share->user->name,
            ],
            'medicines' => $medicines->map(function($medicine) {
                return [
                    'id' => $medicine->id,
                    'name' => $medicine->name,
                    'dosage' => $medicine->dosage,
                    'frequency' => $medicine->frequency,
                    'notes' => $medicine->notes,
                    'current_quantity' => $medicine->current_quantity,
                    'quantity_unit' => $medicine->quantity_unit,
                    'recent_doses' => $medicine->doses->map(function($dose) {
                        return [
                            'scheduled_time' => $dose->scheduled_time,
                            'status' => $dose->status,
                            'taken_at' => $dose->taken_at,
                        ];
                    }),
                ];
            }),
        ];

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * Export treatment plan as PDF
     */
    public function exportPdf(Request $request)
    {
        // TODO: Implement PDF export using DomPDF or similar
        return response()->json([
            'success' => false,
            'message' => 'PDF export قيد التطوير',
        ], 501);
    }

    /**
     * Export treatment plan as Excel
     */
    public function exportExcel(Request $request)
    {
        // TODO: Implement Excel export using PhpSpreadsheet
        return response()->json([
            'success' => false,
            'message' => 'Excel export قيد التطوير',
        ], 501);
    }

    /**
     * Get all shares for authenticated user
     */
    public function index(Request $request)
    {
        $shares = TreatmentPlanShare::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $shares->map(function($share) {
                return [
                    'id' => $share->id,
                    'token' => $share->token,
                    'url' => url("/shared/treatment-plan/{$share->token}"),
                    'recipient_email' => $share->recipient_email,
                    'recipient_name' => $share->recipient_name,
                    'format' => $share->format,
                    'expires_at' => $share->expires_at,
                    'views_count' => $share->views_count,
                    'last_viewed_at' => $share->last_viewed_at,
                    'is_active' => $share->is_active,
                    'created_at' => $share->created_at,
                ];
            }),
        ]);
    }

    /**
     * Deactivate share link
     */
    public function deactivate($id)
    {
        $share = TreatmentPlanShare::where('user_id', auth()->id())
            ->findOrFail($id);

        $share->update(['is_active' => false]);

        return response()->json([
            'success' => true,
            'message' => 'تم تعطيل رابط المشاركة',
        ]);
    }

    /**
     * Delete share link
     */
    public function destroy($id)
    {
        $share = TreatmentPlanShare::where('user_id', auth()->id())
            ->findOrFail($id);

        $share->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف رابط المشاركة',
        ]);
    }
}
