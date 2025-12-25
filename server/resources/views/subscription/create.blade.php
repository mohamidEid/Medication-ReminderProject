@extends('layouts.dashboard')

@section('title', 'الاشتراك')
@section('header', 'الاشتراك في الخدمة')

@section('content')
    <div class="max-w-4xl mx-auto space-y-8">

        {{-- Success Message --}}
        @if (session('success'))
            <div
                class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-2xl p-8 border border-green-200 dark:border-green-800 animate-pulse">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-16 h-16 bg-green-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-green-900 dark:text-green-100">✅ تم بنجاح!</h3>
                        <p class="text-green-700 dark:text-green-300">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @php
            $subscription = Auth::user()->subscription;
            $latestReceipt = Auth::user()->subscriptionReceipts()->latest()->first();
            $hasPendingRequest = Auth::user()->subscriptionReceipts()->where('status', 'pending')->exists();
            $hasRejectedRequest = $latestReceipt && $latestReceipt->status === 'rejected';
        @endphp

        {{-- Active Subscription --}}
        @if ($subscription && $subscription->status === 'active')
            <div
                class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-2xl p-8 border border-green-200 dark:border-green-800 mb-6">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 bg-green-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-green-900 dark:text-green-100">✅ اشتراكك نشط!</h3>
                        <p class="text-green-700 dark:text-green-300">شكراً لانضمامك إلينا - استمتع بجميع المميزات</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="bg-white dark:bg-green-900/30 rounded-xl p-4">
                        <p class="text-sm text-slate-600 dark:text-slate-400 mb-1">تاريخ البدء</p>
                        <p class="text-lg font-bold text-slate-900 dark:text-white">
                            {{ \Carbon\Carbon::parse($subscription->start_date)->format('Y-m-d') }}
                        </p>
                    </div>
                    <div class="bg-white dark:bg-green-900/30 rounded-xl p-4">
                        <p class="text-sm text-slate-600 dark:text-slate-400 mb-1">تاريخ الانتهاء</p>
                        <p class="text-lg font-bold text-slate-900 dark:text-white">
                            {{ \Carbon\Carbon::parse($subscription->end_date)->format('Y-m-d') }}
                        </p>
                    </div>
                    <div class="bg-white dark:bg-green-900/30 rounded-xl p-4">
                        <p class="text-sm text-slate-600 dark:text-slate-400 mb-1">نوع الباقة</p>
                        <p class="text-lg font-bold text-slate-900 dark:text-white">
                            {{ $subscription->plan_type === 'monthly' ? 'شهري' : 'سنوي' }}
                        </p>
                    </div>
                    <div class="bg-white dark:bg-green-900/30 rounded-xl p-4">
                        <p class="text-sm text-slate-600 dark:text-slate-400 mb-1">المبلغ المدفوع</p>
                        <p class="text-lg font-bold text-slate-900 dark:text-white">{{ $subscription->amount }} جنيه</p>
                    </div>
                </div>

                @php
                    $daysRemaining = \Carbon\Carbon::now()->diffInDays(
                        \Carbon\Carbon::parse($subscription->end_date),
                        false,
                    );
                @endphp
                <div class="bg-white dark:bg-green-900/30 rounded-xl p-4 mb-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-600 dark:text-slate-400">الأيام المتبقية</span>
                        <span class="text-2xl font-bold {{ $daysRemaining < 7 ? 'text-orange-600' : 'text-green-600' }}">
                            {{ max(0, $daysRemaining) }} يوم
                        </span>
                    </div>
                    <div class="mt-2 bg-slate-200 dark:bg-slate-700 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full"
                            style="width: {{ min(100, ($daysRemaining / 30) * 100) }}%"></div>
                    </div>
                </div>

                <div class="bg-white dark:bg-green-900/30 rounded-xl p-4">
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-2">
                        <strong>موعد التجديد القادم:</strong>
                    </p>
                    <p class="text-base font-medium text-slate-900 dark:text-white">
                        {{ \Carbon\Carbon::parse($subscription->end_date)->format('Y-m-d') }}
                        (بعد {{ max(0, $daysRemaining) }} يوم)
                    </p>
                    @if ($daysRemaining < 7 && $daysRemaining > 0)
                        <p class="text-sm text-orange-600 dark:text-orange-400 mt-2">
                            ⚠️ اقترب موعد التجديد! يرجى تجديد الاشتراك قريباً
                        </p>
                    @endif
                </div>
            </div>

            {{-- Pending Request --}}
        @elseif($hasPendingRequest)
            <div
                class="bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 rounded-2xl p-8 border border-yellow-200 dark:border-yellow-800">
                <div class="flex items-center gap-4 mb-4">
                    <div
                        class="w-16 h-16 bg-yellow-600 rounded-2xl flex items-center justify-center shadow-lg animate-pulse">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-yellow-900 dark:text-yellow-100">⏳ انتظر حتى مراجعة الطلب</h3>
                        <p class="text-yellow-700 dark:text-yellow-300">طلبك قيد المراجعة من الإدارة، سيتم التفعيل قريباً
                        </p>
                    </div>
                </div>
                <div class="bg-white dark:bg-yellow-900/30 rounded-xl p-4 mt-4">
                    <p class="text-sm text-slate-600 dark:text-slate-400">تم إرسال طلبك بنجاح. سيتم مراجعته خلال <span
                            class="font-bold text-yellow-600">5 دقائق</span></p>
                </div>
            </div>

            {{-- Rejected Request --}}
        @elseif($hasRejectedRequest)
            <div
                class="bg-gradient-to-br from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 rounded-2xl p-8 border border-red-200 dark:border-red-800 mb-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-16 h-16 bg-red-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-red-900 dark:text-red-100">❌ تم رفض الطلب</h3>
                        <p class="text-red-700 dark:text-red-300">يمكنك إعادة المحاولة بطلب جديد</p>
                    </div>
                </div>
                @if ($latestReceipt->admin_notes)
                    <div class="bg-white dark:bg-red-900/30 rounded-xl p-4">
                        <p class="text-sm text-slate-600 dark:text-slate-400 mb-1">سبب الرفض:</p>
                        <p class="text-slate-900 dark:text-white font-medium">{{ $latestReceipt->admin_notes }}</p>
                    </div>
                @endif
            </div>
        @endif

        {{-- Subscription Form (Show if: no active subscription AND (no pending OR rejected)) --}}
        @if ((!$subscription || $subscription->status !== 'active') && !$hasPendingRequest)
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-8 shadow-sm border border-slate-100 dark:border-slate-800">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">اشترك الآن</h2>
                    <p class="text-slate-600 dark:text-slate-400">احصل على جميع المميزات مقابل 100 جنيه شهرياً فقط</p>
                </div>

                <div
                    class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-2xl p-8 mb-8 border border-indigo-200 dark:border-indigo-800">
                    <div class="text-center mb-6">
                        <div class="flex items-baseline justify-center gap-2 mb-4">
                            <span class="text-6xl font-bold text-indigo-600 dark:text-indigo-400">100</span>
                            <div class="text-right">
                                <span class="text-2xl font-bold text-slate-900 dark:text-white">جنيه</span>
                                <span class="block text-sm text-slate-500 dark:text-slate-400">شهرياً</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="text-slate-700 dark:text-slate-300">أدوية غير محدودة</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="text-slate-700 dark:text-slate-300">تذكيرات ذكية</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="text-slate-700 dark:text-slate-300">إشعارات واتساب</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="text-slate-700 dark:text-slate-300">دعم فني 24/7</span>
                        </div>
                    </div>
                </div>

                <form action="{{ route('subscription.submit') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">رقم الهاتف</label>
                        <input type="tel" name="phone" required value="{{ old('phone', Auth::user()->phone) }}"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500/50 outline-none">
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">صورة إيصال
                            الدفع</label>
                        <input type="file" name="receipt_image" accept="image/*" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500/50 outline-none">
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">قم بتحويل 100 جنيه واضف صورة الإيصال</p>
                        @error('receipt_image')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">ملاحظات
                            (اختياري)</label>
                        <textarea name="notes" rows="3"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500/50 outline-none resize-none">{{ old('notes') }}</textarea>
                    </div>

                    <button type="submit"
                        class="w-full py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl font-bold text-lg transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        إرسال الطلب
                    </button>
                </form>

                <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-700">
                    <p class="text-center text-sm text-slate-600 dark:text-slate-400">
                        <strong>خطوات الاشتراك:</strong><br>
                        حول 100 جنيه عبر فودافون كاش على الرقم
                        <span class="font-bold text-indigo-600 dark:text-indigo-400">01027931470</span>
                        ثم ارفع صورة الإيصال
                    </p>
                </div>
            </div>
        @endif

    </div>
@endsection
