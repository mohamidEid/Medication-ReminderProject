<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\Dose;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Get today's doses
        $todayDoses = Dose::where('user_id', $user->id)
            ->with('medicine')
            ->whereDate('scheduled_time', Carbon::today())
            ->orderBy('scheduled_time')
            ->get();

        // Get upcoming doses (next 5)
        $upcomingDoses = Dose::where('user_id', $user->id)
            ->with('medicine')
            ->where('scheduled_time', '>', Carbon::now())
            ->where('status', 'pending')
            ->orderBy('scheduled_time')
            ->limit(5)
            ->get();

        // Get active medicines count
        $activeMedicines = Medicine::where('user_id', $user->id)
            ->where('is_active', true)
            ->count();

        // Calculate adherence rate (last 30 days)
        $thirtyDaysAgo = Carbon::now()->subDays(30);
        $totalDoses = Dose::where('user_id', $user->id)
            ->where('scheduled_time', '>=', $thirtyDaysAgo)
            ->where('scheduled_time', '<=', Carbon::now())
            ->count();

        $takenDoses = Dose::where('user_id', $user->id)
            ->where('status', 'taken')
            ->where('scheduled_time', '>=', $thirtyDaysAgo)
            ->where('scheduled_time', '<=', Carbon::now())
            ->count();

        $adherenceRate = $totalDoses > 0 ? round(($takenDoses / $totalDoses) * 100, 2) : 0;

        // Get weekly stats (last 7 days)
        $weeklyStats = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $taken = Dose::where('user_id', $user->id)
                ->where('status', 'taken')
                ->whereDate('scheduled_time', $date)
                ->count();

            $total = Dose::where('user_id', $user->id)
                ->whereDate('scheduled_time', $date)
                ->count();

            $weeklyStats[] = [
                'date' => $date->format('Y-m-d'),
                'day' => $date->format('D'),
                'taken' => $taken,
                'total' => $total,
                'rate' => $total > 0 ? round(($taken / $total) * 100, 2) : 0,
            ];
        }

        return response()->json([
            'today_doses' => $todayDoses,
            'upcoming_doses' => $upcomingDoses,
            'active_medicines' => $activeMedicines,
            'adherence_rate' => $adherenceRate,
            'weekly_stats' => $weeklyStats,
            'stats' => [
                'total_doses_30_days' => $totalDoses,
                'taken_doses_30_days' => $takenDoses,
                'missed_doses_30_days' => Dose::where('user_id', $user->id)
                    ->where('status', 'missed')
                    ->where('scheduled_time', '>=', $thirtyDaysAgo)
                    ->count(),
            ]
        ]);
    }
}
