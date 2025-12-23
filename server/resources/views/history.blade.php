@extends('layouts.dashboard')

@section('title', 'سجل الجرعات')
@section('header', 'سجل الجرعات')

@section('content')
    <div class="space-y-8">

        <!-- Filter Bar -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-800">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">من تاريخ</label>
                    <input type="date"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500/50 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">إلى تاريخ</label>
                    <input type="date"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500/50 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">الحالة</label>
                    <select
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500/50 outline-none">
                        <option value="">الكل</option>
                        <option value="taken">تم الأخذ</option>
                        <option value="missed">فائتة</option>
                        <option value="skipped">متجاوزة</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button
                        class="w-full px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold transition-all shadow-lg shadow-indigo-200 dark:shadow-none flex items-center justify-center gap-2">
                        <i data-lucide="filter" class="w-5 h-5"></i>
                        <span>تطبيق الفلتر</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div
                class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-2xl p-6 border border-green-100 dark:border-green-800">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-500 text-white rounded-xl flex items-center justify-center shadow-lg">
                        <i data-lucide="check-circle-2" class="w-6 h-6"></i>
                    </div>
                    <span class="text-2xl font-bold text-green-600 dark:text-green-400">85%</span>
                </div>
                <h3 class="text-lg font-bold text-green-900 dark:text-green-100">نسبة الالتزام</h3>
                <p class="text-sm text-green-700 dark:text-green-300 mt-1">17 من 20 جرعة</p>
            </div>

            <div
                class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl p-6 border border-blue-100 dark:border-blue-800">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-500 text-white rounded-xl flex items-center justify-center shadow-lg">
                        <i data-lucide="calendar-check" class="w-6 h-6"></i>
                    </div>
                    <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">7</span>
                </div>
                <h3 class="text-lg font-bold text-blue-900 dark:text-blue-100">أيام متتالية</h3>
                <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">سلسلة الالتزام الحالية</p>
            </div>

            <div
                class="bg-gradient-to-br from-rose-50 to-red-50 dark:from-rose-900/20 dark:to-red-900/20 rounded-2xl p-6 border border-rose-100 dark:border-rose-800">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-rose-500 text-white rounded-xl flex items-center justify-center shadow-lg">
                        <i data-lucide="alert-circle" class="w-6 h-6"></i>
                    </div>
                    <span class="text-2xl font-bold text-rose-600 dark:text-rose-400">3</span>
                </div>
                <h3 class="text-lg font-bold text-rose-900 dark:text-rose-100">جرعات فائتة</h3>
                <p class="text-sm text-rose-700 dark:text-rose-300 mt-1">خلال آخر 7 أيام</p>
            </div>
        </div>

        <!-- History Timeline -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-8 shadow-sm border border-slate-100 dark:border-slate-800">
            <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                <i data-lucide="history" class="w-6 h-6 text-indigo-500"></i>
                السجل التفصيلي
            </h3>

            <div class="space-y-6">
                <!-- Sample History Items -->
                @php
                    $sampleHistory = [
                        [
                            'date' => 'اليوم',
                            'time' => '09:00 ص',
                            'medicine' => 'بانادول',
                            'dosage' => '500mg',
                            'status' => 'taken',
                            'notes' => 'تم الأخذ في الموعد',
                        ],
                        [
                            'date' => 'اليوم',
                            'time' => '02:00 م',
                            'medicine' => 'فيتامين د',
                            'dosage' => '1000 IU',
                            'status' => 'taken',
                            'notes' => 'تم الأخذ مع الطعام',
                        ],
                        [
                            'date' => 'أمس',
                            'time' => '09:00 ص',
                            'medicine' => 'بانادول',
                            'dosage' => '500mg',
                            'status' => 'missed',
                            'notes' => 'لم يتم الأخذ',
                        ],
                        [
                            'date' => 'أمس',
                            'time' => '09:00 م',
                            'medicine' => 'أسبرين',
                            'dosage' => '100mg',
                            'status' => 'taken',
                            'notes' => 'تم الأخذ متأخراً 30 دقيقة',
                        ],
                    ];
                @endphp

                @foreach ($sampleHistory as $item)
                    <div
                        class="flex items-start gap-4 p-4 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors group">
                        <div class="flex-shrink-0">
                            @if ($item['status'] === 'taken')
                                <div
                                    class="w-12 h-12 bg-green-50 dark:bg-green-900/20 text-green-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i data-lucide="check" class="w-6 h-6"></i>
                                </div>
                            @elseif($item['status'] === 'missed')
                                <div
                                    class="w-12 h-12 bg-rose-50 dark:bg-rose-900/20 text-rose-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i data-lucide="x" class="w-6 h-6"></i>
                                </div>
                            @else
                                <div
                                    class="w-12 h-12 bg-slate-50 dark:bg-slate-800 text-slate-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i data-lucide="minus" class="w-6 h-6"></i>
                                </div>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-4 mb-2">
                                <div>
                                    <h4 class="font-bold text-slate-800 dark:text-white text-lg">{{ $item['medicine'] }}
                                    </h4>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">{{ $item['dosage'] }}</p>
                                </div>
                                <div class="text-left">
                                    <p class="text-sm font-bold text-slate-600 dark:text-slate-300">{{ $item['date'] }}</p>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">{{ $item['time'] }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                @if ($item['status'] === 'taken')
                                    <span
                                        class="inline-flex items-center gap-1 px-3 py-1 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 rounded-lg text-xs font-bold">
                                        <i data-lucide="check-circle-2" class="w-3 h-3"></i>
                                        تم الأخذ
                                    </span>
                                @elseif($item['status'] === 'missed')
                                    <span
                                        class="inline-flex items-center gap-1 px-3 py-1 bg-rose-50 dark:bg-rose-900/20 text-rose-700 dark:text-rose-300 rounded-lg text-xs font-bold">
                                        <i data-lucide="alert-circle" class="w-3 h-3"></i>
                                        فائتة
                                    </span>
                                @endif
                                <span class="text-sm text-slate-600 dark:text-slate-400">{{ $item['notes'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex items-center justify-between">
                <p class="text-sm text-slate-500 dark:text-slate-400">عرض 1-10 من 45 سجل</p>
                <div class="flex gap-2">
                    <button
                        class="px-4 py-2 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        السابق
                    </button>
                    <button
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg font-bold hover:bg-indigo-700 transition-colors">
                        1
                    </button>
                    <button
                        class="px-4 py-2 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        2
                    </button>
                    <button
                        class="px-4 py-2 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        التالي
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
