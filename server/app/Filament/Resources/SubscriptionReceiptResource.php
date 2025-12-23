<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriptionReceiptResource\Pages;
use App\Filament\Resources\SubscriptionReceiptResource\RelationManagers;
use App\Models\SubscriptionReceipt;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubscriptionReceiptResource extends Resource
{
    protected static ?string $model = SubscriptionReceipt::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Payment Receipts';

    protected static ?string $slug = 'payment-receipts';

    protected static ?string $navigationGroup = 'Payments';


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
                    ->required()
                    ->maxLength(255),

                Forms\Components\FileUpload::make('receipt_path')
                    ->label('Receipt Image')
                    ->image()
                    ->required()
                    ->directory('receipts'),

                Forms\Components\Textarea::make('notes')
                    ->label('Customer Notes')
                    ->columnSpanFull(),

                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending Review',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->required()
                    ->default('pending')
                    ->reactive()
                    ->afterStateUpdated(function ($state, $record) {
                        // This will trigger when status changes
                        if ($record && $state === 'approved') {
                            // Create subscription automatically
                            static::createSubscriptionFromReceipt($record);
                        }
                    }),

                Forms\Components\Textarea::make('admin_notes')
                    ->label('Admin Notes')
                    ->columnSpanFull(),

                Forms\Components\DateTimePicker::make('reviewed_at')
                    ->label('Reviewed At'),

                Forms\Components\TextInput::make('reviewed_by')
                    ->numeric()
                    ->label('Reviewed By (Admin ID)'),
            ]);
    }

    protected static function createSubscriptionFromReceipt($receipt)
    {
        // Auto-create subscription when approved
        \App\Models\Subscription::updateOrCreate(
            ['user_id' => $receipt->user_id],
            [
                'plan_type' => 'monthly', // Default
                'status' => 'active',
                'start_date' => now(),
                'end_date' => now()->addMonth(),
                'payment_id' => $receipt->id,
                'amount' => 100, // Default amount
            ]
        );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('receipt_path')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('reviewed_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reviewed_by')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ExportBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Tables\Actions\ExportAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
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
