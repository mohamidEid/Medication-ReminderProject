@extends('layouts.dashboard')

@section('title', 'تفاصيل الإيصال')
@section('header', 'تفاصيل إيصال الاشتراك')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">

        {{-- Header with Actions --}}
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-800">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white">
                        إيصال #{{ str_pad($receipt->id, 6, '0', STR_PAD_LEFT) }}
                    </h2>
                    <p class="text-slate-600 dark:text-slate-400 mt-1">
                        تاريخ الإرسال: {{ $receipt->created_at->format('Y-m-d H:i') }}
                    </p>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('receipts.download', $receipt->id) }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl font-semibold transition-all shadow-md hover:shadow-lg">
                        <i data-lucide="download" class="w-5 h-5"></i>
                        تحميل PDF
                    </a>
                </div>
            </div>
        </div>

        {{-- Status Badge --}}
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-800">
            <div class="flex items-center gap-4">
                @if ($receipt->status === 'approved')
                    <div class="w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-2xl flex items-center justify-center">
                        <i data-lucide="check-circle" class="w-8 h-8 text-green-600 dark:text-green-400"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-green-600 dark:text-green-400">تم الاعتماد ✓</h3>
                        <p class="text-slate-600 dark:text-slate-400">اشتراكك نشط الآن</p>
                    </div>
                @elseif($receipt->status === 'pending')
                    <div
                        class="w-16 h-16 bg-yellow-100 dark:bg-yellow-900/30 rounded-2xl flex items-center justify-center animate-pulse">
                        <i data-lucide="clock" class="w-8 h-8 text-yellow-600 dark:text-yellow-400"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-yellow-600 dark:text-yellow-400">قيد المراجعة ⏳</h3>
                        <p class="text-slate-600 dark:text-slate-400">سيتم المراجعة خلال 5 دقائق</p>
                    </div>
                @else
                    <div class="w-16 h-16 bg-red-100 dark:bg-red-900/30 rounded-2xl flex items-center justify-center">
                        <i data-lucide="x-circle" class="w-8 h-8 text-red-600 dark:text-red-400"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-red-600 dark:text-red-400">مرفوض ✗</h3>
                        <p class="text-slate-600 dark:text-slate-400">يرجى التواصل مع الدعم</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Receipt Details --}}
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-800">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">تفاصيل الطلب</h3>

            <div class="space-y-3">
                <div class="flex justify-between py-3 border-b border-slate-100 dark:border-slate-800">
                    <span class="text-slate-600 dark:text-slate-400">رقم الهاتف:</span>
                    <span class="font-semibold text-slate-900 dark:text-white" dir="ltr">{{ $receipt->phone }}</span>
                </div>

                <div class="flex justify-between py-3 border-b border-slate-100 dark:border-slate-800">
                    <span class="text-slate-600 dark:text-slate-400">المبلغ:</span>
                    <span class="font-semibold text-slate-900 dark:text-white">100 جنيه</span>
                </div>

                @if ($receipt->notes)
                    <div class="py-3">
                        <span class="text-slate-600 dark:text-slate-400 block mb-2">ملاحظاتك:</span>
                        <p class="text-slate-900 dark:text-white bg-slate-50 dark:bg-slate-800 p-4 rounded-lg">
                            {{ $receipt->notes }}</p>
                    </div>
                @endif

                @if ($receipt->admin_notes)
                    <div class="py-3">
                        <span class="text-slate-600 dark:text-slate-400 block mb-2">ملاحظات الإدارة:</span>
                        <p
                            class="text-slate-900 dark:text-white bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg border border-yellow-200 dark:border-yellow-800">
                            {{ $receipt->admin_notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Receipt Image --}}
        @if ($receipt->receipt_path)
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-800">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">صورة الإيصال</h3>
                <img src="{{ Storage::url($receipt->receipt_path) }}" alt="إيصال الدفع"
                    class="w-full h-auto rounded-xl border-2 border-slate-200 dark:border-slate-700">
            </div>
        @endif

        {{-- Back Button --}}
        <div class="flex justify-center">
            <a href="{{ route('subscription.create') }}"
                class="inline-flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white">
                <i data-lucide="arrow-right" class="w-5 h-5"></i>
                العودة للاشتراك
            </a>
        </div>
    </div>
@endsection
