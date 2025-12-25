<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriptionReceiptResource\Pages;
use App\Models\SubscriptionReceipt;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SubscriptionReceiptResource extends Resource
{
    protected static ?string $model = SubscriptionReceipt::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'طلبات الاشتراك';
    protected static ?string $slug = 'subscription-receipts';
    protected static ?string $navigationGroup = 'الاشتراكات';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'email')
                    ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required(),

                Forms\Components\FileUpload::make('receipt_path')
                    ->label('صورة الإيصال')
                    ->image()
                    ->required()
                    ->directory('receipts'),

                Forms\Components\Textarea::make('notes')
                    ->label('ملاحظات العميل')
                    ->columnSpanFull(),

                Forms\Components\Select::make('status')
                    ->label('الحالة')
                    ->options([
                        'pending' => 'قيد المراجعة',
                        'approved' => 'معتمد',
                        'rejected' => 'مرفوض',
                    ])
                    ->required()
                    ->default('pending'),

                Forms\Components\Textarea::make('admin_notes')
                    ->label('ملاحظات الإدارة')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('المستخدم')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('user.email')
                    ->label('البريد')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('phone')
                    ->label('الهاتف')
                    ->searchable(),
                    
                Tables\Columns\ImageColumn::make('receipt_path')
                    ->label('الإيصال')
                    ->square(),
                    
                Tables\Columns\BadgeColumn::make('status')
                    ->label('الحالة')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ])
                    ->formatStateUsing(fn ($state) => [
                        'pending' => 'قيد المراجعة',
                        'approved' => 'معتمد',
                        'rejected' => 'مرفوض',
                    ][$state] ?? $state),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإرسال')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('الحالة')
                    ->options([
                        'pending' => 'قيد المراجعة',
                        'approved' => 'معتمد',
                        'rejected' => 'مرفوض',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                
                Tables\Actions\Action::make('approve')
                    ->label('موافقة')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('موافقة على الاشتراك')
                    ->modalDescription('هل أنت متأكد من الموافقة؟')
                    ->visible(fn ($record) => $record->status === 'pending')
->action(function ($record) {
    $record->update([
        'status' => 'approved',
        'reviewed_at' => now(),
        'reviewed_by' => auth()->id(),
    ]);
    
    // Delete old subscription if exists
    \App\Models\Subscription::where('user_id', $record->user_id)->delete();
    
    // Create new subscription
    $sub = new \App\Models\Subscription();
    $sub->forceFill([
        'user_id' => $record->user_id,
        'plan_type' => 'monthly',
        'status' => 'active',
        'start_date' => now(),
        'end_date' => now()->addMonth(),
        'payment_id' => $record->id,
        'amount' => 100,
    ])->save();
    
    \Filament\Notifications\Notification::make()
        ->title('تمت الموافقة على الاشتراك')
        ->success()
        ->send();
}),
                    
                Tables\Actions\Action::make('reject')
                    ->label('رفض')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('رفض الاشتراك')
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->form([
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('سبب الرفض')
                            ->required(),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'status' => 'rejected',
                            'admin_notes' => $data['admin_notes'],
                            'reviewed_at' => now(),
                            'reviewed_by' => auth()->id(),
                        ]);
                        
                        \Filament\Notifications\Notification::make()
                            ->title('تم رفض الاشتراك')
                            ->danger()
                            ->send();
                    }),
                    
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscriptionReceipts::route('/'),
            'create' => Pages\CreateSubscriptionReceipt::route('/create'),
            'edit' => Pages\EditSubscriptionReceipt::route('/{record}/edit'),
        ];
    }
}
