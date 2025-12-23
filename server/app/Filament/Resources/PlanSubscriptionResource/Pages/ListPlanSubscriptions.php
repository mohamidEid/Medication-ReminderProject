<?php

namespace App\Filament\Resources\PlanSubscriptionResource\Pages;

use App\Filament\Resources\PlanSubscriptionResource;
use Filament\Resources\Pages\ListRecords;

class ListPlanSubscriptions extends ListRecords
{
    protected static string $resource = PlanSubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
