<?php

namespace App\Filament\Resources\SubscriptionReceiptResource\Pages;

use App\Filament\Resources\SubscriptionReceiptResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubscriptionReceipt extends EditRecord
{
    protected static string $resource = SubscriptionReceiptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
