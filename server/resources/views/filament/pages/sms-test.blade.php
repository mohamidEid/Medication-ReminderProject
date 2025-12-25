<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Provider Status Card -->
        <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
            <h3 class="text-lg font-semibold mb-4">📊 حالة SMS Provider</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div
                    class="p-4 rounded-lg {{ $providerInfo['sms_configured'] ? 'bg-green-50 dark:bg-green-900/20' : 'bg-red-50 dark:bg-red-900/20' }}">
                    <div class="flex items-center gap-2">
                        @if ($providerInfo['sms_configured'])
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        @else
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        @endif
                        <span class="font-medium">SMS Provider</span>
                    </div>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        {{ $providerInfo['sms_provider'] }}
                    </p>
                    <p class="text-xs {{ $providerInfo['sms_configured'] ? 'text-green-600' : 'text-red-600' }}">
                        {{ $providerInfo['sms_configured'] ? '✓ مُفعّل' : '✗ غير مُفعّل' }}
                    </p>
                </div>

                <div
                    class="p-4 rounded-lg {{ $providerInfo['whatsapp_configured'] ? 'bg-green-50 dark:bg-green-900/20' : 'bg-gray-50 dark:bg-gray-900/20' }}">
                    <div class="flex items-center gap-2">
                        @if ($providerInfo['whatsapp_configured'])
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        @else
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        @endif
                        <span class="font-medium">WhatsApp</span>
                    </div>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Twilio WhatsApp
                    </p>
                    <p class="text-xs {{ $providerInfo['whatsapp_configured'] ? 'text-green-600' : 'text-gray-500' }}">
                        {{ $providerInfo['whatsapp_configured'] ? '✓ مُفعّل' : '✗ غير مُفعّل' }}
                    </p>
                </div>
            </div>

            @unless ($providerInfo['sms_configured'])
                <div
                    class="mt-4 p-4 rounded-lg bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800">
                    <p class="text-sm text-yellow-800 dark:text-yellow-200">
                        ⚠️ <strong>SMS غير مُفعّل:</strong> أضف إعدادات SMS في ملف <code
                            class="px-1 py-0.5 bg-yellow-100 dark:bg-yellow-900 rounded">.env</code>
                    </p>
                    <p class="text-xs text-yellow-700 dark:text-yellow-300 mt-2">
                        راجع <code>SMS_GUIDE.md</code> للمزيد من التفاصيل
                    </p>
                </div>
            @endunless
        </div>

        <!-- Test Form -->
        <form wire:submit="sendSms">
            {{ $this->form }}

            <div class="mt-6 flex gap-3">
                <x-filament::button type="submit" color="primary" icon="heroicon-o-paper-airplane">
                    إرسال SMS
                </x-filament::button>

                <x-filament::button type="button" wire:click="sendMedicineReminder" color="success"
                    icon="heroicon-o-bell">
                    إرسال تذكير
                </x-filament::button>
            </div>
        </form>

        <!-- Help Section -->
        <div class="rounded-lg bg-gray-50 dark:bg-gray-900/50 p-6">
            <h4 class="font-semibold mb-3">💡 نصائح سريعة</h4>
            <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                <li class="flex items-start gap-2">
                    <span class="text-blue-600">→</span>
                    <span>تأكد من أن رقم الهاتف يبدأ بـ <code>+</code> ورمز الدولة (مثال: +20)</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-blue-600">→</span>
                    <span>الرسائل محدودة بـ 160 حرف للـ SMS العادي</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-blue-600">→</span>
                    <span>جميع الرسائل يتم تسجيلها في <code>storage/logs/laravel.log</code></span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-blue-600">→</span>
                    <span>اقرأ <code>SMS_GUIDE.md</code> لإعداد SMS Provider</span>
                </li>
            </ul>
        </div>
    </div>
</x-filament-panels::page>
