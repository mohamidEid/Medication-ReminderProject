@extends('layouts.dashboard')

@section('title', 'الاشتراك')
@section('header', 'الاشتراك في الخدمة')

@section('content')
    <div class="max-w-4xl mx-auto space-y-8">

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-2xl p-8 border border-green-200 dark:border-green-800 animate-pulse">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-16 h-16 bg-green-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <i data-lucide="check-circle-2" class="w-8 h-8 text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-green-900 dark:text-green-100">✅ تم بنجاح!</h3>
                        <p class="text-green-700 dark:text-green-300">{{ session('success') }}</p>
                    </div>
                </div>
                
                @php
                    $latestReceipt = Auth::user()->subscriptionReceipts()->latest()->first();
                @endphp
                
                @if($latestReceipt)
                    <div class="mt-4 flex gap-3">
                        <a href="{{ route('receipts.print', $latestReceipt->id) }}" 
                           class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-semibold transition-all shadow-md hover:shadow-lg">
                            <i data-lucide="download" class="w-5 h-5"></i>
                            طباعة الإيصال
                        </a>
                        <a href="{{ route('receipts.show', $latestReceipt->id) }}" 
                           class="inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-green-600 dark:text-green-400 border-2 border-green-600 dark:border-green-400 rounded-xl font-semibold transition-all">
                            <i data-lucide="eye" class="w-5 h-5"></i>
                            عرض الإيصال
                        </a>
                    </div>
                @endif
            </div>
        @endif


        <!-- Current Subscription Status -->
        @if (Auth::user()->subscription && Auth::user()->subscription->status === 'active')
            <div
                class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-2xl p-8 border border-green-200 dark:border-green-800">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-16 h-16 bg-green-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <i data-lucide="check-circle-2" class="w-8 h-8 text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-green-900 dark:text-green-100">اشتراكك نشط!</h3>
                        <p class="text-green-700 dark:text-green-300">تنتهي صلاحية اشتراكك في:
                            {{ Auth::user()->subscription->ends_at->format('Y-m-d') }}</p>
                    </div>
                </div>
            </div>
        @elseif(Auth::user()->subscription && Auth::user()->subscription->status === 'pending')
            <div
                class="bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 rounded-2xl p-8 border border-yellow-200 dark:border-yellow-800">
                <div class="flex items-center gap-4 mb-4">
                    <div
                        class="w-16 h-16 bg-yellow-600 rounded-2xl flex items-center justify-center shadow-lg animate-pulse">
                        <i data-lucide="clock" class="w-8 h-8 text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-yellow-900 dark:text-yellow-100">قيد المراجعة</h3>
                        <p class="text-yellow-700 dark:text-yellow-300">اشتراكك قيد المراجعة، سيتم تفعيله خلال 5 دقائق</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Subscription Form -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-8 shadow-sm border border-slate-100 dark:border-slate-800">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">اشترك الآن</h2>
                <p class="text-slate-600 dark:text-slate-400">احصل على جميع المميزات مقابل 100 جنيه شهرياً فقط</p>
            </div>

            <!-- Pricing Card -->
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
                        <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                        <span class="text-slate-700 dark:text-slate-300">أدوية غير محدودة</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm">
                        <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                        <span class="text-slate-700 dark:text-slate-300">إشعارات واتساب</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm">
                        <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                        <span class="text-slate-700 dark:text-slate-300">رسائل SMS</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm">
                        <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                        <span class="text-slate-700 dark:text-slate-300">دعم فني 24/7</span>
                    </div>
                </div>
            </div>

            <!-- Payment Instructions -->
            <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-6 mb-8">
                <h3 class="font-bold text-lg text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                    <i data-lucide="info" class="w-5 h-5 text-indigo-600"></i>
                    خطوات الاشتراك
                </h3>
                <ol class="space-y-3 text-slate-700 dark:text-slate-300">
                    <li class="flex gap-3">
                        <span
                            class="flex-shrink-0 w-6 h-6 bg-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-bold">1</span>
                        <span>قم بتحويل <strong class="text-indigo-600 dark:text-indigo-400">100 جنيه</strong> عبر فودافون
                            كاش إلى الرقم: <strong dir="ltr">01027931470</strong></span>
                    </li>
                    <li class="flex gap-3">
                        <span
                            class="flex-shrink-0 w-6 h-6 bg-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-bold">2</span>
                        <span>التقط صورة لإيصال التحويل (Screenshot)</span>
                    </li>
                    <li class="flex gap-3">
                        <span
                            class="flex-shrink-0 w-6 h-6 bg-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-bold">3</span>
                        <span>ارفع الإيصال في النموذج أدناه</span>
                    </li>
                    <li class="flex gap-3">
                        <span
                            class="flex-shrink-0 w-6 h-6 bg-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-bold">4</span>
                        <span>انتظر التفعيل (لن يستغرق أكثر من <strong class="text-green-600">5 دقائق</strong>)</span>
                    </li>
                </ol>
            </div>

            <!-- Upload Form -->
            <form action="{{ route('subscription.submit') }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                        رقم الهاتف المستخدم في التحويل
                    </label>
                    <input type="tel" name="phone" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500/50 outline-none"
                        placeholder="01XXXXXXXXX" dir="ltr">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                        صورة إيصال التحويل
                    </label>
                    <div class="relative">
                        <input type="file" name="receipt" accept="image/*" required
                            class="w-full px-4 py-3 rounded-xl border-2 border-dashed border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500/50 outline-none file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">
                            <i data-lucide="image" class="w-3 h-3 inline-block"></i>
                            يُقبل: JPG, PNG (حجم أقصى: 5MB)
                        </p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                        ملاحظات إضافية (اختياري)
                    </label>
                    <textarea name="notes" rows="3"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500/50 outline-none"
                        placeholder="أي ملاحظات تود إضافتها..."></textarea>
                </div>

                <div
                    class="flex items-start gap-3 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-xl border border-yellow-200 dark:border-yellow-800">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5"></i>
                    <p class="text-sm text-yellow-800 dark:text-yellow-200">
                        <strong>مهم:</strong> تأكد من وضوح الإيصال وظهور رقم العملية والمبلغ المحول. المراجعة والتفعيل ستتم
                        خلال 5 دقائق كحد أقصى.
                    </p>
                </div>

                <button type="submit"
                    class="w-full px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-2xl font-bold text-lg transition-all shadow-xl hover:shadow-2xl flex items-center justify-center gap-2">
                    <i data-lucide="upload" class="w-5 h-5"></i>
                    إرسال طلب الاشتراك
                </button>
            </form>
        </div>

        <!-- Support -->
        <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-6 text-center">
            <p class="text-slate-600 dark:text-slate-400 mb-2">تحتاج مساعدة؟</p>
            <div class="flex items-center justify-center gap-4">
                <a href="https://wa.me/201027931470" target="_blank"
                    class="inline-flex items-center gap-2 text-green-600 dark:text-green-400 hover:underline font-medium">
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    واتساب
                </a>
                <span class="text-slate-300 dark:text-slate-700">|</span>
                <a href="tel:01027931470"
                    class="inline-flex items-center gap-2 text-indigo-600 dark:text-indigo-400 hover:underline font-medium">
                    <i data-lucide="phone" class="w-4 h-4"></i>
                    اتصل بنا
                </a>
            </div>
        </div>
    </div>
@endsection
