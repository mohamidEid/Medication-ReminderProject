<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Medicine;
use App\Models\Dose;
use App\Models\Subscription;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalUsers = User::count();
        $activeSubscriptions = Subscription::where('status', 'active')->count();
        $totalMedicines = Medicine::count();
        $todayDoses = Dose::whereDate('scheduled_time', today())->count();

        return [
            Stat::make('Total Users', $totalUsers)
                ->description('All registered users')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),

            Stat::make('Active Subscriptions', $activeSubscriptions)
                ->description('Currently active')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color('warning'),

            Stat::make('Total Medicines', $totalMedicines)
                ->description('In the system')
                ->descriptionIcon('heroicon-m-beaker')
                ->color('info'),

            Stat::make('Today\'s Doses', $todayDoses)
                ->description('Scheduled for today')
                ->descriptionIcon('heroicon-m-clock')
                ->color('primary'),
        ];
    }
}
