<?php

use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\SendMedicationReminders;

Schedule::command('medication:send-reminders')->everyMinute();
