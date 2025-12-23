<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dose;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Carbon\Carbon;

class DoseController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $query = $request->user()->doses()->with('medicine');

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('from')) {
            $query->where('scheduled_time', '>=', $request->from);
        }
        if ($request->has('to')) {
            $query->where('scheduled_time', '<=', $request->to);
        }

        $doses = $query->orderBy('scheduled_time', 'desc')->get();

        return response()->json($doses);
    }

    public function today(Request $request)
    {
        $doses = $request->user()
            ->doses()
            ->with('medicine')
            ->whereDate('scheduled_time', Carbon::today())
            ->orderBy('scheduled_time')
            ->get();

        return response()->json($doses);
    }

    public function upcoming(Request $request)
    {
        $doses = $request->user()
            ->doses()
            ->with('medicine')
            ->where('scheduled_time', '>', Carbon::now())
            ->where('status', 'pending')
            ->orderBy('scheduled_time')
            ->limit(10)
            ->get();

        return response()->json($doses);
    }

    public function markAsTaken(Request $request, Dose $dose)
    {
        $this->authorize('update', $dose);

        $dose->update([
            'status' => 'taken',
            'taken_time' => now(),
            'notes' => $request->notes,
        ]);

        return response()->json($dose);
    }

    public function markAsMissed(Request $request, Dose $dose)
    {
        $this->authorize('update', $dose);

        $dose->update([
            'status' => 'missed',
            'notes' => $request->notes,
        ]);

        return response()->json($dose);
    }

    public function markAsSkipped(Request $request, Dose $dose)
    {
        $this->authorize('update', $dose);

        $dose->update([
            'status' => 'skipped',
            'notes' => $request->notes,
        ]);

        return response()->json($dose);
    }

    public function stats(Request $request)
    {
        $userId = $request->user()->id;

        $total = Dose::where('user_id', $userId)->count();
        $taken = Dose::where('user_id', $userId)->where('status', 'taken')->count();
        $missed = Dose::where('user_id', $userId)->where('status', 'missed')->count();
        $pending = Dose::where('user_id', $userId)->where('status', 'pending')->count();

        $adherenceRate = $total > 0 ? round(($taken / $total) * 100, 2) : 0;

        return response()->json([
            'total' => $total,
            'taken' => $taken,
            'missed' => $missed,
            'pending' => $pending,
            'adherence_rate' => $adherenceRate,
        ]);
    }
}
