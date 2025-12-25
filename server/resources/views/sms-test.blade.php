@extends('layouts.dashboard')

@section('title', 'اختبار SMS')
@section('header', 'اختبار إرسال SMS')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Status Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                        <i data-lucide="smartphone" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 dark:text-white">SMS Provider</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400" id="provider-name">جاري التحميل...</p>
                    </div>
                </div>
                <div id="provider-status" class="text-sm"></div>
            </div>

            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 dark:text-white">WhatsApp</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400" id="whatsapp-status">جاري التحميل...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Test SMS Form -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-800">
            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-6">📱 إرسال SMS تجريبي</h3>

            <form id="sms-form" class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                        رقم الهاتف
                    </label>
                    <input type="tel" id="phone" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500/50 outline-none"
                        placeholder="+201234567890" dir="ltr">
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">يجب أن يبدأ بـ + ورمز الدولة</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                        الرسالة
                    </label>
                    <textarea id="message" rows="3" required maxlength="160"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500/50 outline-none"
                        placeholder="اكتب رسالتك هنا...">🔔 اختبار رسالة من MediRemind</textarea>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">الحد الأقصى 160 حرف (<span
                            id="char-count">0</span>/160)</p>
                </div>

                <button type="submit"
                    class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl font-bold transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                    <i data-lucide="send" class="w-5 h-5"></i>
                    إرسال SMS
                </button>
            </form>

            <div id="result" class="mt-4 hidden"></div>
        </div>

        <!-- Medicine Reminder Form -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-800">
            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-6">💊 إرسال تذكير بالدواء</h3>

            <form id="reminder-form" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                            رقم الهاتف
                        </label>
                        <input type="tel" id="reminder-phone" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-green-500/50 outline-none"
                            placeholder="+201234567890" dir="ltr">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                            اسم الدواء
                        </label>
                        <input type="text" id="medicine-name" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-green-500/50 outline-none"
                            placeholder="باراسيتامول 500mg">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                            الموعد
                        </label>
                        <input type="time" id="medicine-time" required value="08:00"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-green-500/50 outline-none">
                    </div>
                </div>

                <button type="submit"
                    class="w-full px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-xl font-bold transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                    <i data-lucide="bell" class="w-5 h-5"></i>
                    إرسال تذكير
                </button>
            </form>

            <div id="reminder-result" class="mt-4 hidden"></div>
        </div>

        <!-- Help Section -->
        <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl p-6">
            <h4 class="font-bold text-slate-900 dark:text-white mb-4">💡 نصائح سريعة</h4>
            <ul class="space-y-2 text-sm text-slate-600 dark:text-slate-400">
                <li class="flex items-start gap-2">
                    <span class="text-blue-600">→</span>
                    <span>تأكد من أن رقم الهاتف يبدأ بـ <code
                            class="px-1 py-0.5 bg-slate-100 dark:bg-slate-700 rounded">+</code> ورمز الدولة</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-blue-600">→</span>
                    <span>الحد الأقصى للرسالة 160 حرف</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-blue-600">→</span>
                    <span>جميع الرسائل يتم تسجيلها في <code
                            class="px-1 py-0.5 bg-slate-100 dark:bg-slate-700 rounded">storage/logs/laravel.log</code></span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-blue-600">→</span>
                    <span>اقرأ <code class="px-1 py-0.5 bg-slate-100 dark:bg-slate-700 rounded">SMS_GUIDE.md</code> لإعداد
                        SMS Provider</span>
                </li>
            </ul>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Load provider info
            loadProviderInfo();

            // Character counter
            const messageInput = document.getElementById('message');
            const charCount = document.getElementById('char-count');

            messageInput.addEventListener('input', function() {
                charCount.textContent = this.value.length;
            });
            charCount.textContent = messageInput.value.length;

            // SMS Form
            document.getElementById('sms-form').addEventListener('submit', async function(e) {
                e.preventDefault();

                const phone = document.getElementById('phone').value;
                const message = document.getElementById('message').value;
                const resultDiv = document.getElementById('result');

                try {
                    const response = await fetch('/api/test/sms', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            phone,
                            message
                        })
                    });

                    const data = await response.json();

                    resultDiv.className =
                        `mt-4 p-4 rounded-xl ${data.success ? 'bg-green-50 dark:bg-green-900/20 text-green-800 dark:text-green-200' : 'bg-red-50 dark:bg-red-900/20 text-red-800 dark:text-red-200'}`;
                    resultDiv.innerHTML = `
                <strong>${data.success ? '✓' : '✗'} ${data.message}</strong>
                ${!data.success ? '<p class="text-sm mt-2">تحقق من إعدادات SMS Provider في .env</p>' : ''}
            `;
                    resultDiv.classList.remove('hidden');

                } catch (error) {
                    resultDiv.className =
                        'mt-4 p-4 rounded-xl bg-red-50 dark:bg-red-900/20 text-red-800 dark:text-red-200';
                    resultDiv.innerHTML = '<strong>✗ خطأ في الإرسال</strong><p class="text-sm mt-2">' +
                        error.message + '</p>';
                    resultDiv.classList.remove('hidden');
                }
            });

            // Reminder Form
            document.getElementById('reminder-form').addEventListener('submit', async function(e) {
                e.preventDefault();

                const phone = document.getElementById('reminder-phone').value;
                const medicine_name = document.getElementById('medicine-name').value;
                const time = document.getElementById('medicine-time').value;
                const resultDiv = document.getElementById('reminder-result');

                try {
                    const response = await fetch('/api/test/medicine-reminder', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            phone,
                            medicine_name,
                            time
                        })
                    });

                    const data = await response.json();

                    resultDiv.className =
                        `mt-4 p-4 rounded-xl ${data.success ? 'bg-green-50 dark:bg-green-900/20 text-green-800 dark:text-green-200' : 'bg-red-50 dark:bg-red-900/20 text-red-800 dark:text-red-200'}`;
                    resultDiv.innerHTML =
                    `<strong>${data.success ? '✓' : '✗'} ${data.message}</strong>`;
                    resultDiv.classList.remove('hidden');

                } catch (error) {
                    resultDiv.className =
                        'mt-4 p-4 rounded-xl bg-red-50 dark:bg-red-900/20 text-red-800 dark:text-red-200';
                    resultDiv.innerHTML = '<strong>✗ خطأ في الإرسال</strong>';
                    resultDiv.classList.remove('hidden');
                }
            });

            async function loadProviderInfo() {
                try {
                    const response = await fetch('/api/test/provider-info');
                    const data = await response.json();

                    document.getElementById('provider-name').textContent = data.provider.sms_provider;
                    document.getElementById('provider-status').innerHTML = data.provider.sms_configured ?
                        '<span class="text-green-600 dark:text-green-400">✓ مُفعّل</span>' :
                        '<span class="text-red-600 dark:text-red-400">✗ غير مفعّل - راجع .env</span>';

                    document.getElementById('whatsapp-status').innerHTML = data.provider.whatsapp_configured ?
                        '<span class="text-green-600 dark:text-green-400">✓ مُفعّل</span>' :
                        '<span class="text-gray-500">✗ غير مُفعّل</span>';

                } catch (error) {
                    console.error('Failed to load provider info:', error);
                }
            }
        });
    </script>
@endsection
