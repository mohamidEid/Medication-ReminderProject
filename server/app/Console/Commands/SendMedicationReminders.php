<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Dose;
use App\Notifications\MedicationReminder;
use Carbon\Carbon;

class SendMedicationReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'medication:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for scheduled doses and send WhatsApp reminders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $this->info("Checking for medication reminders for: " . $now->format('Y-m-d H:i'));

        // Find doses scheduled for the current minute that are 'pending'
        // Note: In a real app, you might want a range (e.g., last 5 minutes) to avoid missing runs
        $startWindow = $now->copy()->startOfMinute();
        $endWindow = $now->copy()->endOfMinute();

        $doses = Dose::with(['user', 'medicine'])
            ->where('status', 'pending')
            ->whereBetween('scheduled_time', [$startWindow, $endWindow])
            ->get();

        $this->info("Found {$doses->count()} doses to remind.");

        foreach ($doses as $dose) {
            $user = $dose->user;

            if ($user && $user->phone) {
                try {
                    $user->notify(new MedicationReminder($dose));
                    $this->info("Reminder sent to {$user->name} ({$user->phone}) for {$dose->medicine->name}");
                } catch (\Exception $e) {
                    $this->error("Failed to send reminder to {$user->name}: " . $e->getMessage());
                }
            } else {
                $this->warn("User for dose {$dose->id} has no phone number associated.");
            }
        }
    }
}
