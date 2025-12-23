@extends('layouts.dashboard')

@section('title', 'الجدول الزمني')
@section('header', 'الجدول الزمني')

@section('content')
    <div class="space-y-8">

        <!-- Week Navigator -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-800">
            <div class="flex items-center justify-between">
                <button class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">
                    <i data-lucide="chevron-right" class="w-6 h-6 text-slate-600 dark:text-slate-400"></i>
                </button>

                <h3 class="text-xl font-bold text-slate-800 dark:text-white">
                    {{ \Carbon\Carbon::now()->locale('ar')->isoFormat('MMMM YYYY') }}
                </h3>

                <button class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">
                    <i data-lucide="chevron-left" class="w-6 h-6 text-slate-600 dark:text-slate-400"></i>
                </button>
            </div>

            <!-- Days of Week -->
            <div class="grid grid-cols-7 gap-2 mt-6">
                @php
                    $daysOfWeek = ['الأحد', 'الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'];
                    $today = \Carbon\Carbon::now();
                @endphp

                @foreach ($daysOfWeek as $index => $day)
                    @php
                        $date = $today->copy()->startOfWeek()->addDays($index);
                        $isToday = $date->isToday();
                    @endphp
                    <div class="text-center">
                        <p class="text-xs font-bold text-slate-500 dark:text-slate-400 mb-2">{{ $day }}</p>
                        <button
                            class="w-full aspect-square rounded-xl flex flex-col items-center justify-center transition-all {{ $isToday ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200 dark:shadow-none' : 'bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                            <span class="text-2xl font-bold">{{ $date->format('d') }}</span>
                            @if ($isToday)
                                <span class="text-xs mt-1">اليوم</span>
                            @endif
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Today's Schedule -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-8 shadow-sm border border-slate-100 dark:border-slate-800">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-slate-800 dark:text-white flex items-center gap-2">
                    <i data-lucide="calendar-days" class="w-6 h-6 text-indigo-500"></i>
                    جدول اليوم
                </h3>
                <span
                    class="px-4 py-2 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 rounded-xl font-bold text-sm">
                    {{ \Carbon\Carbon::now()->locale('ar')->isoFormat('dddd، D MMMM') }}
                </span>
            </div>

            <div class="space-y-4">
                @php
                    $schedule = [
                        [
                            'time' => '08:00',
                            'period' => 'ص',
                            'medicines' => [
                                ['name' => 'بانادول', 'dosage' => '500mg', 'instructions' => 'قبل الإفطار'],
                                ['name' => 'فيتامين د', 'dosage' => '1000 IU', 'instructions' => 'مع الطعام'],
                            ],
                        ],
                        [
                            'time' => '02:00',
                            'period' => 'م',
                            'medicines' => [
                                ['name' => 'أوميجا 3', 'dosage' => '1000mg', 'instructions' => 'بعد الغداء'],
                            ],
                        ],
                        [
                            'time' => '08:00',
                            'period' => 'م',
                            'medicines' => [['name' => 'أسبرين', 'dosage' => '100mg', 'instructions' => 'قبل النوم']],
                        ],
                    ];
                @endphp

                @foreach ($schedule as $slot)
                    <div class="group relative">
                        <div
                            class="absolute right-0 top-0 bottom-0 w-1 bg-indigo-200 dark:bg-indigo-800 rounded-full group-hover:bg-indigo-500 transition-colors">
                        </div>

                        <div class="pr-6 pb-6 last:pb-0">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 text-center min-w-[80px]">
                                    <div
                                        class="inline-flex items-baseline gap-1 px-4 py-2 bg-slate-50 dark:bg-slate-800 rounded-xl">
                                        <span
                                            class="text-2xl font-bold text-slate-800 dark:text-white">{{ $slot['time'] }}</span>
                                        <span
                                            class="text-sm text-slate-500 dark:text-slate-400">{{ $slot['period'] }}</span>
                                    </div>
                                </div>

                                <div class="flex-1 space-y-3">
                                    @foreach ($slot['medicines'] as $medicine)
                                        <div
                                            class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-4 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                                            <div class="flex items-start justify-between gap-4 mb-3">
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="w-10 h-10 bg-gradient-to-tr from-indigo-500 to-violet-500 text-white rounded-lg flex items-center justify-center shadow-lg">
                                                        <i data-lucide="pill" class="w-5 h-5"></i>
                                                    </div>
                                                    <div>
                                                        <h4 class="font-bold text-slate-800 dark:text-white">
                                                            {{ $medicine['name'] }}</h4>
                                                        <p class="text-sm text-slate-500 dark:text-slate-400">
                                                            {{ $medicine['dosage'] }}</p>
                                                    </div>
                                                </div>

                                                <div class="flex gap-2">
                                                    <button
                                                        class="p-2 bg-green-50 dark:bg-green-900/20 text-green-600 hover:bg-green-100 dark:hover:bg-green-900/40 rounded-lg transition-colors"
                                                        title="تم الأخذ">
                                                        <i data-lucide="check" class="w-5 h-5"></i>
                                                    </button>
                                                    <button
                                                        class="p-2 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-600 rounded-lg transition-colors"
                                                        title="تأجيل">
                                                        <i data-lucide="clock" class="w-5 h-5"></i>
                                                    </button>
                                                    <button
                                                        class="p-2 bg-rose-50 dark:bg-rose-900/20 text-rose-600 hover:bg-rose-100 dark:hover:bg-rose-900/40 rounded-lg transition-colors"
                                                        title="تخطي">
                                                        <i data-lucide="x" class="w-5 h-5"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                                                <i data-lucide="info" class="w-4 h-4"></i>
                                                <span>{{ $medicine['instructions'] }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Upcoming Days Preview -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-800">
                <h4 class="font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <i data-lucide="calendar-plus" class="w-5 h-5 text-indigo-500"></i>
                    غداً
                </h4>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 rounded-lg flex items-center justify-center">
                                <i data-lucide="pill" class="w-4 h-4"></i>
                            </div>
                            <span class="font-medium text-slate-700 dark:text-slate-300">بانادول</span>
                        </div>
                        <span class="text-sm text-slate-500 dark:text-slate-400">08:00 ص</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 rounded-lg flex items-center justify-center">
                                <i data-lucide="pill" class="w-4 h-4"></i>
                            </div>
                            <span class="font-medium text-slate-700 dark:text-slate-300">أسبرين</span>
                        </div>
                        <span class="text-sm text-slate-500 dark:text-slate-400">08:00 م</span>
                    </div>
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-2xl p-6 border border-indigo-100 dark:border-indigo-800">
                <h4 class="font-bold text-indigo-900 dark:text-indigo-100 mb-4 flex items-center gap-2">
                    <i data-lucide="lightbulb" class="w-5 h-5 text-indigo-500"></i>
                    نصيحة اليوم
                </h4>
                <p class="text-indigo-700 dark:text-indigo-300 leading-relaxed">
                    تناول الأدوية في نفس الوقت يومياً يساعد على تذكرها بشكل أفضل ويحسن فعاليتها. حاول ربط موعد الدواء بنشاط
                    يومي ثابت.
                </p>
            </div>
        </div>
    </div>
@endsection
