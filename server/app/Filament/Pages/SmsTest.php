<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use App\Services\NotificationService;

class SmsTest extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-device-phone-mobile';

    protected static ?string $navigationLabel = 'اختبار SMS';

    protected static ?string $navigationGroup = 'الإشعارات';

    protected static string $view = 'filament.pages.sms-test';

    public ?array $data = [];

    public $providerInfo = [];

    public function mount(): void
    {
        $this->form->fill();
        $this->loadProviderInfo();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('إرسال SMS تجريبي')
                    ->description('استخدم هذه الصفحة لاختبار إرسال SMS')
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->label('رقم الهاتف')
                            ->tel()
                            ->required()
                            ->placeholder('+201234567890')
                            ->helperText('يجب أن يبدأ بـ + ورمز الدولة'),

                        Forms\Components\Textarea::make('message')
                            ->label('الرسالة')
                            ->required()
                            ->rows(3)
                            ->maxLength(160)
                            ->helperText('الحد الأقصى 160 حرف')
                            ->default('🔔 اختبار رسالة من MediRemind'),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('إرسال تذكير بالدواء')
                    ->schema([
                        Forms\Components\TextInput::make('reminder_phone')
                            ->label('رقم الهاتف')
                            ->tel()
                            ->required()
                            ->placeholder('+201234567890'),

                        Forms\Components\TextInput::make('medicine_name')
                            ->label('اسم الدواء')
                            ->required()
                            ->placeholder('باراسيتامول 500mg'),

                        Forms\Components\TimePicker::make('medicine_time')
                            ->label('موعد الدواء')
                            ->required()
                            ->default('08:00'),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    public function sendSms(): void
    {
        $data = $this->form->getState();

        $service = app(NotificationService::class);
        $sent = $service->sendSms($data['phone'], $data['message']);

        if ($sent) {
            Notification::make()
                ->title('تم الإرسال بنجاح')
                ->success()
                ->body("تم إرسال SMS إلى {$data['phone']}")
                ->send();
        } else {
            Notification::make()
                ->title('فشل الإرسال')
                ->danger()
                ->body('تحقق من إعدادات SMS Provider في .env')
                ->send();
        }

        $this->loadProviderInfo();
    }

    public function sendMedicineReminder(): void
    {
        $data = $this->form->getState();

        $service = app(NotificationService::class);
        $sent = $service->sendMedicineReminder(
            $data['reminder_phone'],
            $data['medicine_name'],
            $data['medicine_time']
        );

        if ($sent) {
            Notification::make()
                ->title('تم إرسال التذكير')
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('فشل إرسال التذكير')
                ->danger()
                ->send();
        }

        $this->loadProviderInfo();
    }

    protected function loadProviderInfo(): void
    {
        $service = app(NotificationService::class);
        $this->providerInfo = $service->getProviderInfo();
    }

    protected function getFormActions(): array
    {
        return [
            Forms\Components\Actions\Action::make('sendSms')
                ->label('إرسال SMS')
                ->action('sendSms')
                ->color('primary')
                ->icon('heroicon-o-paper-airplane'),

            Forms\Components\Actions\Action::make('sendReminder')
                ->label('إرسال تذكير')
                ->action('sendMedicineReminder')
                ->color('success')
                ->icon('heroicon-o-bell'),
        ];
    }
}
