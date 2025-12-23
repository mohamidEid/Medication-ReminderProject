<?php

namespace App\Services;

use App\Models\Alert;
use App\Models\User;
use App\Models\Dose;
use App\Models\Medicine;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * AlertService - manages all alert types
 */
class AlertService
{
    /**
     * Create an alert for a user
     */
    public function createAlert(User $user, string $type, string $title, string $message, array $data = [], string $priority = 'medium'): Alert
    {
        return Alert::create([
            'user_id' => $user->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
            'priority' => $priority,
        ]);
    }

    /**
     * Check for dose conflicts (doses too close together)
     */
    public function checkDoseConflicts(User $user, int $hoursThreshold = 2): void
    {
        $doses = Dose::where('user_id', $user->id)
            ->whereDate('scheduled_time', today())
            ->whereTime('scheduled_time', '>', now())
            ->orderBy('scheduled_time')
            ->get();

        for ($i = 0; $i < $doses->count() - 1; $i++) {
            $current = $doses[$i];
            $next = $doses[$i + 1];

            $diff = $current->scheduled_time->diffInHours($next->scheduled_time);

            if ($diff < $hoursThreshold) {
                $this->createAlert(
                    $user,
                    'dose_conflict',
                    'جرعات متقاربة',
                    "لديك جرعتان متقاربتان: {$current->medicine->name} و {$next->medicine->name} بفارق {$diff} ساعة فقط",
                    [
                        'dose1_id' => $current->id,
                        'dose2_id' => $next->id,
                        'time_difference_hours' => $diff,
                    ],
                    'medium'
                );
            }
        }
    }

    /**
     * Check for missed doses
     */
    public function checkMissedDoses(User $user): void
    {
        $missedDoses = Dose::where('user_id', $user->id)
            ->where('status', 'pending')
            ->where('scheduled_time', '<', now()->subHours(2))
            ->get();

        foreach ($missedDoses as $dose) {
            // Check if alert already exists
            $existingAlert = Alert::where('user_id', $user->id)
                ->where('type', 'missed_dose')
                ->where('data->dose_id', $dose->id)
                ->where('created_at', '>', now()->subDays(1))
                ->first();

            if (!$existingAlert) {
                $this->createAlert(
                    $user,
                    'missed_dose',
                    'جرعة فائتة',
                    "لم تأخذ جرعة {$dose->medicine->name} المجدولة في {$dose->scheduled_time->format('H:i')}",
                    [
                        'dose_id' => $dose->id,
                        'medicine_id' => $dose->medicine_id,
                        'scheduled_time' => $dose->scheduled_time->toISOString(),
                    ],
                    'high'
                );
            }
        }
    }

    /**
     * Check for delayed doses
     */
    public function checkDelayedDoses(User $user): void
    {
        $delayedDoses = Dose::where('user_id', $user->id)
            ->where('status', 'pending')
            ->where('scheduled_time', '<', now())
            ->where('scheduled_time', '>', now()->subHours(2))
            ->get();

        foreach ($delayedDoses as $dose) {
            $delay = now()->diffInMinutes($dose->scheduled_time);

            if ($delay > 30) {
                $existingAlert = Alert::where('user_id', $user->id)
                    ->where('type', 'delayed_dose')
                    ->where('data->dose_id', $dose->id)
                    ->where('created_at', '>', now()->subHours(1))
                    ->first();

                if (!$existingAlert) {
                    $this->createAlert(
                        $user,
                        'delayed_dose',
                        'جرعة متأخرة',
                        "جرعة {$dose->medicine->name} متأخرة بـ {$delay} دقيقة",
                        [
                            'dose_id' => $dose->id,
                            'medicine_id' => $dose->medicine_id,
                            'delay_minutes' => $delay,
                        ],
                        'medium'
                    );
                }
            }
        }
    }

    /**
     * Check for multiple medications at the same time
     */
    public function checkMultipleDosesAtSameTime(User $user): void
    {
        $upcomingDoses = Dose::where('user_id', $user->id)
            ->where('status', 'pending')
            ->whereDate('scheduled_time', today())
            ->get()
            ->groupBy(function ($dose) {
                return $dose->scheduled_time->format('H:i');
            });

        foreach ($upcomingDoses as $time => $doses) {
            if ($doses->count() > 2) {
                $medicineNames = $doses->pluck('medicine.name')->join('، ');

                $existingAlert = Alert::where('user_id', $user->id)
                    ->where('type', 'multiple_doses')
                    ->where('data->time', $time)
                    ->where('created_at', '>', now()->subDays(1))
                    ->first();

                if (!$existingAlert) {
                    $this->createAlert(
                        $user,
                        'multiple_doses',
                        'أدوية متعددة في نفس الوقت',
                        "لديك {$doses->count()} أدوية في الساعة {$time}: {$medicineNames}",
                        [
                            'time' => $time,
                            'dose_ids' => $doses->pluck('id')->toArray(),
                            'medicine_count' => $doses->count(),
                        ],
                        'low'
                    );
                }
            }
        }
    }

    /**
     * Run all alert checks for a user
     */
    public function runAllChecks(User $user): void
    {
        $this->checkDoseConflicts($user);
        $this->checkMissedDoses($user);
        $this->checkDelayedDoses($user);
        $this->checkMultipleDosesAtSameTime($user);
    }

    /**
     * Get unread alerts count
     */
    public function getUnreadCount(User $user): int
    {
        return Alert::where('user_id', $user->id)
            ->unread()
            ->active()
            ->count();
    }

    /**
     * Get active alerts
     */
    public function getActiveAlerts(User $user, ?string $type = null): Collection
    {
        $query = Alert::where('user_id', $user->id)
            ->active()
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc');

        if ($type) {
            $query->ofType($type);
        }

        return $query->get();
    }

    /**
     * Mark all alerts as read
     */
    public function markAllAsRead(User $user): int
    {
        return Alert::where('user_id', $user->id)
            ->unread()
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
    }
}
