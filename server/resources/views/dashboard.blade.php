@extends('layouts.dashboard')

@section('title', 'نظرة عامة')
@section('header', 'نظرة عامة')

@section('content')
    <div class="space-y-8">

        <!-- Welcome Banner -->
        <div
            class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 to-violet-600 p-8 md:p-10 shadow-xl shadow-indigo-200 dark:shadow-none text-white">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-indigo-400 opacity-20 rounded-full blur-2xl">
            </div>

            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div>
                    <h2 class="text-3xl font-bold mb-2">
                        @php
                            $hour = now()->hour;
                            $greeting = $hour < 12 ? 'صباح الخير' : ($hour < 18 ? 'مساء الخير' : 'مساء الخير');
                        @endphp
                        {{ $greeting }}، {{ Auth::user()->name }}! 👋
                    </h2>
                    <p class="text-indigo-100 text-lg opacity-90 max-w-xl">
                        @php
                            $medicineCount = Auth::user()->medicines()->count();
                            $todayDoses = 0; // TODO: Calculate from actual doses
                        @endphp
                        @if ($medicineCount > 0)
                            لديك <span
                                class="font-bold text-white bg-white/20 px-2 py-0.5 rounded-lg border border-white/10">{{ $todayDoses }}
                                جرعات</span> مجدولة لليوم من أصل {{ $medicineCount }} دواء نشط.
                        @else
                            لم تقم بإضافة أي أدوية بعد. ابدأ بإضافة أول دواء لك!
                        @endif
                    </p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('medicines.index') }}"
                        class="bg-white text-indigo-600 px-6 py-3 rounded-xl font-bold hover:bg-indigo-50 transition-colors shadow-lg shadow-black/5 flex items-center gap-2">
                        <i data-lucide="plus" class="w-5 h-5"></i>
                        <span>إضافة دواء</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Stat Card 1 -->
            <div
                class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 flex flex-col justify-between group hover:border-indigo-200 dark:hover:border-indigo-900 transition-colors">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-blue-50 dark:bg-blue-900/20 text-blue-600 p-3 rounded-xl">
                        <i data-lucide="clock" class="w-6 h-6"></i>
                    </div>
                    <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">قادم</span>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-slate-800 dark:text-white mb-1">3</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">جرعات متبقية اليوم</p>
                </div>
            </div>

            <!-- Stat Card 2 -->
            <div
                class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 flex flex-col justify-between group hover:border-emerald-200 dark:hover:border-emerald-900 transition-colors">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 p-3 rounded-xl">
                        <i data-lucide="check-circle-2" class="w-6 h-6"></i>
                    </div>
                    <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">مكتمل</span>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-slate-800 dark:text-white mb-1">12</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">جرعة تم أخذها هذا الأسبوع</p>
                </div>
            </div>

            <!-- Stat Card 3 -->
            <div
                class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 flex flex-col justify-between group hover:border-rose-200 dark:hover:border-rose-900 transition-colors">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-rose-50 dark:bg-rose-900/20 text-rose-600 p-3 rounded-xl">
                        <i data-lucide="alert-circle" class="w-6 h-6"></i>
                    </div>
                    <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">فائتة</span>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-slate-800 dark:text-white mb-1">0</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">جرعات فائتة</p>
                </div>
            </div>

            <!-- Stat Card 4 -->
            <div
                class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 flex flex-col justify-between group hover:border-purple-200 dark:hover:border-purple-900 transition-colors">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-purple-50 dark:bg-purple-900/20 text-purple-600 p-3 rounded-xl">
                        <i data-lucide="pill" class="w-6 h-6"></i>
                    </div>
                    <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">نشط</span>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-slate-800 dark:text-white mb-1">5</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">أدوية نشطة حالياً</p>
                </div>
            </div>
        </div>

        <!-- Main Content Split -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Today's Schedule (Takes 2/3 width) -->
            <div class="lg:col-span-2 space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white flex items-center gap-2">
                        <i data-lucide="calendar-days" class="w-5 h-5 text-indigo-500"></i>
                        الجدول الزمني لليوم
                    </h3>
                    <a href="#"
                        class="text-sm font-bold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400">عرض الكل
                        &larr;</a>
                </div>

                <!-- Empty State -->
                <div
                    class="bg-white dark:bg-slate-900 rounded-3xl p-10 text-center border-2 border-dashed border-slate-200 dark:border-slate-800 flex flex-col items-center justify-center min-h-[300px]">
                    <div
                        class="w-20 h-20 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mb-6 animate-pulse">
                        <i data-lucide="check" class="w-10 h-10 text-slate-300 dark:text-slate-600"></i>
                    </div>
                    <h4 class="text-xl font-bold text-slate-800 dark:text-white mb-2">رائع! لا توجد جرعات قادمة</h4>
                    <p class="text-slate-500 dark:text-slate-400 max-w-sm mx-auto mb-6">لقد أتممت جميع مهامك لهذا اليوم،
                        استرح قليلاً 😴</p>
                    <button class="text-indigo-600 font-bold text-sm hover:underline">عرض جدول الغد</button>
                </div>
            </div>

            <!-- Right Side Widgets (Takes 1/3 width) -->
            <div class="space-y-6">
                <!-- Weekly Progress -->
                <div
                    class="bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-sm border border-slate-100 dark:border-slate-800">
                    <h3 class="font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                        <i data-lucide="bar-chart-2" class="w-5 h-5 text-slate-400"></i>
                        الالتزام الأسبوعي
                    </h3>

                    <div class="h-48 flex items-end justify-between gap-2 px-2">
                        <!-- Fake Bars for Demo -->
                        @foreach ([60, 80, 40, 90, 100, 75, 50] as $height)
                            <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-t-xl relative group overflow-hidden"
                                style="height: 100%;">
                                <div class="absolute bottom-0 w-full bg-indigo-500 rounded-t-xl transition-all duration-500 group-hover:bg-indigo-600"
                                    style="height: {{ $height }}%"></div>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex justify-between mt-3 text-xs font-bold text-slate-400 uppercase">
                        <span>S</span><span>M</span><span>T</span><span>W</span><span>T</span><span>F</span><span>S</span>
                    </div>
                </div>

                <!-- Quick Tip -->
                <div
                    class="bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/10 dark:to-teal-900/10 rounded-3xl p-6 border border-emerald-100 dark:border-emerald-900/30">
                    <div class="flex gap-4">
                        <div
                            class="bg-white dark:bg-emerald-900 text-emerald-600 dark:text-emerald-400 p-3 rounded-xl h-fit shadow-sm">
                            <i data-lucide="lightbulb" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-emerald-900 dark:text-emerald-100 mb-1">نصيحة طبية</h4>
                            <p class="text-sm text-emerald-700 dark:text-emerald-300/80 leading-relaxed">
                                شرب الماء بانتظام يساعد على امتصاص الدواء بشكل أفضل ويقلل من الآثار الجانبية.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
