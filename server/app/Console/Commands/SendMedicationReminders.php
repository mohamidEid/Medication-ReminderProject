<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Dose;
use App\Notifications\MedicationReminder;
use Carbon\Carbon;

class SendMedicationReminders extends Command
{
    protected $signature = 'medication:send-reminders';
    protected $description = 'Check for scheduled doses and send reminders (only for active subscribers)';

    public function handle()
    {
        $now = Carbon::now();
        $this->info("Checking for medication reminders for: " . $now->format('Y-m-d H:i'));

        $startWindow = $now->copy()->startOfMinute();
        $endWindow = $now->copy()->endOfMinute();

        $doses = Dose::with(['user.subscription', 'medicine'])
            ->where('status', 'pending')
            ->whereBetween('scheduled_time', [$startWindow, $endWindow])
            ->get();

        $this->info("Found {$doses->count()} doses to check.");

        $sentCount = 0;
        $skippedCount = 0;

        foreach ($doses as $dose) {
            $user = $dose->user;

            if (!$user || !$user->phone) {
                $this->warn("User for dose {$dose->id} has no phone number.");
                continue;
            }

            // ✅ التحقق من الاشتراك النشط
            $hasActiveSubscription = $user->subscription 
                && $user->subscription->status === 'active'
                && $user->subscription->end_date 
                && Carbon::parse($user->subscription->end_date)->isFuture();

            if (!$hasActiveSubscription) {
                $this->warn("⚠️ User {$user->name} - No active subscription. Reminder skipped.");
                $skippedCount++;
                continue;
            }

            try {
                $user->notify(new MedicationReminder($dose));
                $this->info("✅ Reminder sent to {$user->name} for {$dose->medicine->name}");
                $sentCount++;
            } catch (\Exception $e) {
                $this->error("❌ Failed to send reminder to {$user->name}: " . $e->getMessage());
            }
        }

        $this->info("\n📊 Summary:");
        $this->info("   Sent: {$sentCount}");
        $this->info("   Skipped (no subscription): {$skippedCount}");
    }
}
