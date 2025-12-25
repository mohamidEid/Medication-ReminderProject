<?php

namespace App\Services;

use App\Models\Dose;
use Carbon\Carbon;

/**
 * Dose Service
 *
 * Handles dose scheduling and tracking
 */
class DoseService
{
    /**
     * Mark dose as taken
     *
     * @param Dose $dose
     * @return Dose
     */
    public function markAsTaken(Dose $dose): Dose
    {
        $dose->update([
            'status' => 'taken',
            'taken_at' => now(),
        ]);

        return $dose;
    }

    /**
     * Mark dose as skipped
     *
     * @param Dose $dose
     * @return Dose
     */
    public function markAsSkipped(Dose $dose): Dose
    {
        $dose->update([
            'status' => 'skipped',
        ]);

        return $dose;
    }

    /**
     * Get today's doses for user
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTodaysDoses(int $userId)
    {
        return Dose::with('medicine')
            ->where('user_id', $userId)
            ->whereDate('scheduled_time', today())
            ->orderBy('scheduled_time')
            ->get();
    }

    /**
     * Get upcoming doses for user
     *
     * @param int $userId
     * @param int $hours
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUpcomingDoses(int $userId, int $hours = 24)
    {
        return Dose::with('medicine')
            ->where('user_id', $userId)
            ->where('status', 'pending')
            ->whereBetween('scheduled_time', [now(), now()->addHours($hours)])
            ->orderBy('scheduled_time')
            ->get();
    }

    /**
     * Get dose statistics for user
     *
     * @param int $userId
     * @return array
     */
    public function getUserStatistics(int $userId): array
    {
        $total = Dose::where('user_id', $userId)->count();
        $taken = Dose::where('user_id', $userId)->where('status', 'taken')->count();
        $skipped = Dose::where('user_id', $userId)->where('status', 'skipped')->count();
        $pending = Dose::where('user_id', $userId)->where('status', 'pending')->count();

        return [
            'total' => $total,
            'taken' => $taken,
            'skipped' => $skipped,
            'pending' => $pending,
            'adherence_rate' => $total > 0 ? round(($taken / $total) * 100, 2) : 0,
        ];
    }

    /**
     * Get doses that need reminders (scheduled within next minute)
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getDosesNeedingReminders()
    {
        $startWindow = now()->startOfMinute();
        $endWindow = now()->endOfMinute();

        return Dose::with(['user.subscription', 'medicine'])
            ->where('status', 'pending')
            ->whereBetween('scheduled_time', [$startWindow, $endWindow])
            ->get();
    }
}
