@extends('layouts.app')

@section('title', 'الرئيسية')

@section('content')
    <!-- Hero Section -->
    <section class="relative min-h-screen pt-40 pb-20 overflow-hidden flex items-center">
        <!-- Background Effects -->
        <div class="absolute top-0 right-0 w-full h-full -z-10 overflow-hidden pointer-events-none">
            <div
                class="absolute -top-[20%] -right-[10%] w-[70rem] h-[70rem] bg-indigo-600/10 dark:bg-indigo-900/20 rounded-full blur-[100px] animate-float">
            </div>
            <div class="absolute top-[20%] -left-[10%] w-[50rem] h-[50rem] bg-purple-600/10 dark:bg-purple-900/20 rounded-full blur-[100px] animate-float"
                style="animation-delay: 2s"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                <!-- Hero Content -->
                <div class="text-right space-y-8 animate-slide-up relative z-10">
                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 font-medium text-sm border border-indigo-100 dark:border-indigo-800">
                        <span class="flex h-2 w-2 rounded-full bg-indigo-600 animate-pulse"></span>
                        تطبيقك الصحي الأول
                    </div>

                    <h1 class="text-5xl lg:text-7xl font-bold leading-tight dark:text-white">
                        لا تنسى
                        <span class="text-transparent bg-clip-text bg-gradient-to-l from-indigo-600 to-purple-600">
                            دواءك أبداً
                        </span>
                    </h1>

                    <p class="text-xl text-slate-600 dark:text-slate-300 leading-relaxed max-w-2xl">
                        تطبيق ذكي لتذكيرك بمواعيد أدويتك بدقة، مع إشعارات واتساب ورسائل نصية لضمان صحتك وسلامة عائلتك.
                    </p>

                    <div class="flex flex-wrap gap-4 pt-4">
                        <a href="{{ route('register') }}"
                            class="px-8 py-4 rounded-2xl bg-indigo-600 text-white font-bold text-lg hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-200 dark:shadow-none hover:shadow-2xl hover:translate-y-[-2px] flex items-center gap-2">
                            ابدأ الآن مجاناً
                            <i data-lucide="arrow-left" class="w-5 h-5"></i>
                        </a>
                        <a href="#demo"
                            class="px-8 py-4 rounded-2xl bg-white dark:bg-slate-800 text-slate-700 dark:text-white font-bold text-lg border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all flex items-center gap-2">
                            <i data-lucide="play-circle" class="w-6 h-6 text-indigo-600"></i>
                            شاهد الفيديو
                        </a>
                    </div>

                    <div class="flex items-center gap-8 pt-8">
                        <div class="flex -space-x-4 space-x-reverse">
                            <div
                                class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center border-2 border-white dark:border-slate-900 text-indigo-600 font-bold">
                                A</div>
                            <div
                                class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center border-2 border-white dark:border-slate-900 text-purple-600 font-bold">
                                M</div>
                            <div
                                class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center border-2 border-white dark:border-slate-900 text-blue-600 font-bold">
                                S</div>
                            <div
                                class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center border-2 border-white dark:border-slate-900 text-slate-600 font-bold text-xs">
                                +1k</div>
                        </div>
                        <div>
                            <div class="flex gap-1 text-yellow-400">
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                            </div>
                            <p class="text-sm text-slate-500 font-medium">أكثر من 1,000 مستخدم سعيد</p>
                        </div>
                    </div>
                </div>

                <!-- Hero Image / Phone Mockup -->
                <div class="relative mt-20 lg:mt-0 animate-float hidden lg:block">
                    <div
                        class="relative z-10 mx-auto w-[300px] h-[600px] bg-slate-900 rounded-[3rem] border-8 border-slate-900 shadow-2xl">
                        <div
                            class="absolute top-0 left-1/2 transform -translate-x-1/2 w-40 h-6 bg-slate-900 rounded-b-2xl z-20">
                        </div>
                        <div class="w-full h-full bg-white dark:bg-slate-800 rounded-[2.5rem] overflow-hidden relative">
                            <!-- App UI Simulation -->
                            <div class="p-6 pt-12 text-right">
                                <div class="flex justify-between items-center mb-6">
                                    <div>
                                        <h4 class="font-bold text-lg dark:text-white">صباح الخير!</h4>
                                        <p class="text-xs text-slate-500">لديك 3 جرعات اليوم</p>
                                    </div>
                                    <div
                                        class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                                        M</div>
                                </div>

                                <!-- Cards -->
                                <div class="space-y-4">
                                    <div
                                        class="bg-indigo-50 dark:bg-indigo-900/20 p-4 rounded-2xl border border-indigo-100 dark:border-indigo-800/50">
                                        <div class="flex justify-between items-start mb-2">
                                            <div class="flex gap-3">
                                                <div class="bg-white dark:bg-slate-800 p-2 rounded-xl text-indigo-600">
                                                    <i data-lucide="pill" class="w-5 h-5"></i>
                                                </div>
                                                <div>
                                                    <h5 class="font-bold dark:text-white">Panadol Extra</h5>
                                                    <p class="text-xs text-slate-500">500mg • بعد الأكل</p>
                                                </div>
                                            </div>
                                            <span
                                                class="text-xs font-bold bg-indigo-100 text-indigo-700 px-2 py-1 rounded-lg">09:00
                                                ص</span>
                                        </div>
                                        <button
                                            class="w-full mt-2 py-2 bg-indigo-600 text-white rounded-xl text-xs font-bold shadow-lg shadow-indigo-200 dark:shadow-none">تم
                                            أخذ الجرعة</button>
                                    </div>

                                    <div
                                        class="bg-white dark:bg-slate-700 p-4 rounded-2xl border border-slate-100 dark:border-slate-600 opacity-60">
                                        <div class="flex justify-between items-start">
                                            <div class="flex gap-3">
                                                <div class="bg-slate-50 dark:bg-slate-800 p-2 rounded-xl text-slate-400">
                                                    <i data-lucide="pill" class="w-5 h-5"></i>
                                                </div>
                                                <div>
                                                    <h5 class="font-bold dark:text-white">Vitamin C</h5>
                                                    <p class="text-xs text-slate-500">1000mg • قرص فوار</p>
                                                </div>
                                            </div>
                                            <span
                                                class="text-xs font-bold bg-slate-100 text-slate-600 px-2 py-1 rounded-lg">02:00
                                                م</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notifications Popup Simulation -->
                            <div class="absolute bottom-10 left-4 right-4 bg-white/90 dark:bg-slate-800/90 backdrop-blur-md p-4 rounded-2xl shadow-xl border border-indigo-100 dark:border-slate-700 animate-slide-up text-right"
                                style="animation-delay: 1s">
                                <div class="flex items-start gap-4">
                                    <div class="bg-green-100 p-2 rounded-full text-green-600">
                                        <i data-lucide="message-circle" class="w-6 h-6"></i>
                                    </div>
                                    <div>
                                        <h6 class="font-bold text-sm dark:text-white">رسالة واتساب جديدة</h6>
                                        <p class="text-xs text-slate-500 mt-1">حان موعد جرعة Panadol Extra. نرجو الالتزام
                                            بالموعد!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-white dark:bg-slate-900 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-bold mb-4 dark:text-white">كل ما تحتاجه لإدارة صحتك</h2>
                <p class="text-slate-600 dark:text-slate-400">مميزات صممت خصيصاً لتجعل حياتك أسهل وأكثر تنظيماً</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div
                    class="p-8 rounded-3xl bg-slate-50 dark:bg-slate-800 border border-transparent dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors group">
                    <div
                        class="w-14 h-14 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i data-lucide="bell" class="w-7 h-7"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 dark:text-white">تذكيرات ذكية</h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">تذكيرات دقيقة تصلك عبر التطبيق، واتساب،
                        والرسائل النصية لضمان عدم نسيان أي جرعة.</p>
                </div>

                <!-- Feature 2 -->
                <div
                    class="p-8 rounded-3xl bg-slate-50 dark:bg-slate-800 border border-transparent dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors group">
                    <div
                        class="w-14 h-14 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i data-lucide="users" class="w-7 h-7"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 dark:text-white">حسابات عائلية</h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">أدر صحة عائلتك بالكامل من مكان واحد. تابع
                        مواعيد أدوية والديك وأطفالك بسهولة.</p>
                </div>

                <!-- Feature 3 -->
                <div
                    class="p-8 rounded-3xl bg-slate-50 dark:bg-slate-800 border border-transparent dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors group">
                    <div
                        class="w-14 h-14 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i data-lucide="bar-chart-2" class="w-7 h-7"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 dark:text-white">تقارير صحية</h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">احصل على تقارير شهرية توضح مدى التزامك
                        بالأدوية وشاركها مع طبيبك بضغطة زر.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Success Story Section -->
    <section
        class="py-24 bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-950/30 dark:to-purple-950/30 relative overflow-hidden">
        <!-- Decorative elements -->
        <div
            class="absolute top-0 left-0 w-96 h-96 bg-indigo-300/20 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2">
        </div>
        <div
            class="absolute bottom-0 right-0 w-96 h-96 bg-purple-300/20 rounded-full blur-3xl translate-x-1/2 translate-y-1/2">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Story Content -->
                <div>
                    <h2 class="text-4xl font-bold dark:text-white leading-tight">
                        كيف غيّر MediRemind حياة
                        <span class="text-transparent bg-clip-text bg-gradient-to-l from-indigo-600 to-purple-600">عائلة
                            أحمد</span>
                    </h2>

                    <div class="space-y-4 text-slate-600 dark:text-slate-300 leading-relaxed">
                        <p class="text-lg">
                            "كنت أعتني بوالدتي المسنة التي تتناول 6 أنواع مختلفة من الأدوية يومياً. كان الأمر مرهقاً
                            ومربكاً، وأحياناً كنا ننسى الجرعات."
                        </p>
                        <p>
                            بعد استخدام MediRemind، أصبح كل شيء منظماً. التنبيهات تصلني وتصل لوالدتي على الواتساب،
                            والتقارير الشهرية ساعدت الطبيب على متابعة حالتها بدقة. <strong
                                class="text-indigo-600 dark:text-indigo-400">لم ننسَ جرعة واحدة منذ 8 أشهر!</strong>
                        </p>
                    </div>

                    <div class="flex items-center gap-4 pt-4">
                        <div
                            class="w-16 h-16 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                            أ
                        </div>
                        <div>
                            <h4 class="font-bold text-lg dark:text-white">أحمد سامي</h4>
                            <p class="text-sm text-slate-500">القاهرة، مصر • يستخدم MediRemind منذ 8 أشهر</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 pt-6">
                        <div
                            class="text-center p-4 rounded-2xl bg-white/50 dark:bg-slate-800/50 backdrop-blur-sm border border-indigo-100 dark:border-slate-700">
                            <div class="text-3xl font-bold text-indigo-600 dark:text-indigo-400 mb-1">100%</div>
                            <div class="text-xs text-slate-600 dark:text-slate-400">نسبة الالتزام</div>
                        </div>
                        <div
                            class="text-center p-4 rounded-2xl bg-white/50 dark:bg-slate-800/50 backdrop-blur-sm border border-indigo-100 dark:border-slate-700">
                            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">6</div>
                            <div class="text-xs text-slate-600 dark:text-slate-400">أدوية يومية</div>
                        </div>
                        <div
                            class="text-center p-4 rounded-2xl bg-white/50 dark:bg-slate-800/50 backdrop-blur-sm border border-indigo-100 dark:border-slate-700">
                            <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-1">0</div>
                            <div class="text-xs text-slate-600 dark:text-slate-400">جرعات منسية</div>
                        </div>
                    </div>
                </div>

                <!-- Visual Element -->
                <div class="order-1 lg:order-2 relative">
                    <div
                        class="relative rounded-3xl overflow-hidden shadow-2xl border-8 border-white dark:border-slate-800">
                        <div
                            class="aspect-[4/3] bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/40 dark:to-purple-900/40 flex items-center justify-center p-8">
                            <div class="space-y-6 w-full">
                                <!-- Calendar Widget -->
                                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-xl">
                                    <div class="flex items-center justify-between mb-4">
                                        <h4 class="font-bold text-lg dark:text-white">ديسمبر 2024</h4>
                                        <div class="flex gap-2">
                                            <i data-lucide="calendar" class="w-5 h-5 text-indigo-600"></i>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-7 gap-2 text-center">
                                        <div class="text-xs text-slate-400 font-medium">س</div>
                                        <div class="text-xs text-slate-400 font-medium">ج</div>
                                        <div class="text-xs text-slate-400 font-medium">خ</div>
                                        <div class="text-xs text-slate-400 font-medium">أ</div>
                                        <div class="text-xs text-slate-400 font-medium">ث</div>
                                        <div class="text-xs text-slate-400 font-medium">ن</div>
                                        <div class="text-xs text-slate-400 font-medium">ح</div>

                                        <div class="w-8 h-8 flex items-center justify-center rounded-lg text-sm"></div>
                                        <div class="w-8 h-8 flex items-center justify-center rounded-lg text-sm"></div>
                                        <div
                                            class="w-8 h-8 flex items-center justify-center rounded-lg text-sm bg-green-100 text-green-700 font-bold relative">
                                            <div class="absolute -top-1 -right-1 w-2 h-2 bg-green-500 rounded-full">
                                            </div>
                                            1
                                        </div>
                                        <div
                                            class="w-8 h-8 flex items-center justify-center rounded-lg text-sm bg-green-100 text-green-700 font-bold">
                                            2</div>
                                        <div
                                            class="w-8 h-8 flex items-center justify-center rounded-lg text-sm bg-green-100 text-green-700 font-bold">
                                            3</div>
                                        <div
                                            class="w-8 h-8 flex items-center justify-center rounded-lg text-sm bg-green-100 text-green-700 font-bold">
                                            4</div>
                                        <div
                                            class="w-8 h-8 flex items-center justify-center rounded-lg text-sm bg-green-100 text-green-700 font-bold">
                                            5</div>
                                    </div>
                                    <div class="mt-4 flex items-center gap-2 text-xs text-slate-500">
                                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                        <span>جميع الجرعات في الموعد</span>
                                    </div>
                                </div>

                                <!-- Achievement Badge -->
                                <div
                                    class="bg-gradient-to-r from-indigo-500 to-purple-500 rounded-2xl p-6 text-white relative overflow-hidden">
                                    <div
                                        class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2">
                                    </div>
                                    <div class="relative z-10">
                                        <div class="flex items-center gap-3 mb-2">
                                            <i data-lucide="award" class="w-8 h-8"></i>
                                            <h5 class="font-bold text-lg">إنجاز رائع!</h5>
                                        </div>
                                        <p class="text-sm opacity-90">انتظام كامل لمدة 240 يوم متتالي 🎉</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-20 bg-white dark:bg-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold dark:text-white mb-3">أرقام تتحدث عن نفسها</h2>
                <p class="text-slate-600 dark:text-slate-400">إحصائيات حقيقية من مستخدمينا</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <!-- Stat 1 -->
                <div class="text-center group">
                    <div
                        class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-indigo-100 to-indigo-200 dark:from-indigo-900/40 dark:to-indigo-800/40 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i data-lucide="users" class="w-10 h-10 text-indigo-600 dark:text-indigo-400"></i>
                    </div>
                    <div class="text-4xl font-bold text-indigo-600 dark:text-indigo-400 mb-2">+10K</div>
                    <div class="text-sm text-slate-600 dark:text-slate-400">مستخدم نشط</div>
                </div>

                <!-- Stat 2 -->
                <div class="text-center group">
                    <div
                        class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-purple-100 to-purple-200 dark:from-purple-900/40 dark:to-purple-800/40 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i data-lucide="bell" class="w-10 h-10 text-purple-600 dark:text-purple-400"></i>
                    </div>
                    <div class="text-4xl font-bold text-purple-600 dark:text-purple-400 mb-2">500K+</div>
                    <div class="text-sm text-slate-600 dark:text-slate-400">تنبيه مُرسل</div>
                </div>

                <!-- Stat 3 -->
                <div class="text-center group">
                    <div
                        class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/40 dark:to-blue-800/40 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i data-lucide="check-circle" class="w-10 h-10 text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <div class="text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2">98%</div>
                    <div class="text-sm text-slate-600 dark:text-slate-400">نسبة الالتزام</div>
                </div>

                <!-- Stat 4 -->
                <div class="text-center group">
                    <div
                        class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-green-100 to-green-200 dark:from-green-900/40 dark:to-green-800/40 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i data-lucide="star" class="w-10 h-10 text-green-600 dark:text-green-400"></i>
                    </div>
                    <div class="text-4xl font-bold text-green-600 dark:text-green-400 mb-2">4.9/5</div>
                    <div class="text-sm text-slate-600 dark:text-slate-400">تقييم المستخدمين</div>
                </div>
            </div>

            <!-- Trust Badges -->
            <div class="mt-16 pt-12 border-t border-slate-200 dark:border-slate-800">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 items-center opacity-60">
                    <div class="text-center">
                        <div class="flex items-center justify-center gap-2 text-slate-600 dark:text-slate-400">
                            <i data-lucide="shield-check" class="w-6 h-6"></i>
                            <span class="font-medium">بيانات مشفرة</span>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="flex items-center justify-center gap-2 text-slate-600 dark:text-slate-400">
                            <i data-lucide="lock" class="w-6 h-6"></i>
                            <span class="font-medium">حماية كاملة</span>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="flex items-center justify-center gap-2 text-slate-600 dark:text-slate-400">
                            <i data-lucide="zap" class="w-6 h-6"></i>
                            <span class="font-medium">سريع جداً</span>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="flex items-center justify-center gap-2 text-slate-600 dark:text-slate-400">
                            <i data-lucide="heart" class="w-6 h-6"></i>
                            <span class="font-medium">صُنع بحب</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-24 bg-slate-50 dark:bg-slate-900 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-bold mb-4 dark:text-white">كيف تبدأ رحلتك؟</h2>
                <p class="text-slate-600 dark:text-slate-400">ثلاث خطوات بسيطة تفصلك عن راحة البال</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                <!-- Connecting Line (Desktop) -->
                <div
                    class="hidden md:block absolute top-1/2 left-0 w-full h-0.5 bg-indigo-100 dark:bg-indigo-900/50 -translate-y-1/2 z-0">
                </div>

                <!-- Step 1 -->
                <div class="relative z-10 text-center group">
                    <div
                        class="w-20 h-20 mx-auto bg-white dark:bg-slate-800 rounded-full flex items-center justify-center border-4 border-indigo-50 dark:border-indigo-900 shadow-xl mb-6 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">1</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2 dark:text-white">أنشئ حسابك</h3>
                    <p class="text-slate-500 dark:text-slate-400">سجل مجاناً في أقل من دقيقة وابدأ في تنظيم صحتك.</p>
                </div>

                <!-- Step 2 -->
                <div class="relative z-10 text-center group">
                    <div
                        class="w-20 h-20 mx-auto bg-white dark:bg-slate-800 rounded-full flex items-center justify-center border-4 border-indigo-50 dark:border-indigo-900 shadow-xl mb-6 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">2</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2 dark:text-white">أضف أدويتك</h3>
                    <p class="text-slate-500 dark:text-slate-400">حدد اسم الدواء، الجرعة، والمواعيد بسهولة تامة.</p>
                </div>

                <!-- Step 3 -->
                <div class="relative z-10 text-center group">
                    <div
                        class="w-20 h-20 mx-auto bg-white dark:bg-slate-800 rounded-full flex items-center justify-center border-4 border-indigo-50 dark:border-indigo-900 shadow-xl mb-6 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">3</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2 dark:text-white">استقبل التنبيهات</h3>
                    <p class="text-slate-500 dark:text-slate-400">سنذكرك في الوقت المحدد عبر التطبيق والواتساب.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-24 bg-white dark:bg-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-bold mb-4 dark:text-white">قصص نجاح نعتز بها</h2>
                <p class="text-slate-600 dark:text-slate-400">انضم للآلاف الذين غيروا حياتهم الصحية للأفضل</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Review 1 -->
                <div
                    class="p-8 rounded-3xl bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 relative">
                    <div class="text-yellow-400 flex gap-1 mb-4">
                        <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                    </div>
                    <p class="text-slate-700 dark:text-slate-300 mb-6 leading-relaxed">
                        "تطبيق مذهل! كنت دائماً أنسى أدوية الضغط الخاصة بوالدي، ولكن الآن بفضل التنبيهات وميزة الواتساب،
                        أصبحنا منتظمين 100%."
                    </p>
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-lg">
                            أ</div>
                        <div>
                            <h4 class="font-bold dark:text-white">أحمد المحمدي</h4>
                            <p class="text-xs text-slate-500">مستخدم منذ 6 أشهر</p>
                        </div>
                    </div>
                </div>

                <!-- Review 2 -->
                <div
                    class="p-8 rounded-3xl bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 relative">
                    <div class="text-yellow-400 flex gap-1 mb-4">
                        <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                    </div>
                    <p class="text-slate-700 dark:text-slate-300 mb-6 leading-relaxed">
                        "واجهة الاستخدام بسيطة جداً وجميلة. أحببت الوضع الليلي والتقارير الشهرية التي أشاركها مع طبيبي.
                        شكراً لكم!"
                    </p>
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center text-purple-700 font-bold text-lg">
                            س</div>
                        <div>
                            <h4 class="font-bold dark:text-white">سارة علي</h4>
                            <p class="text-xs text-slate-500">مستخدمة نشطة</p>
                        </div>
                    </div>
                </div>

                <!-- Review 3 -->
                <div
                    class="p-8 rounded-3xl bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 relative">
                    <div class="text-yellow-400 flex gap-1 mb-4">
                        <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    </div>
                    <p class="text-slate-700 dark:text-slate-300 mb-6 leading-relaxed">
                        "أفضل تطبيق لتذكير الأدوية جربته حتى الآن. لا إعلانات مزعجة، والتركيز كله على خدمة المستخدم. أنصح به
                        بشدة."
                    </p>
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-lg">
                            م</div>
                        <div>
                            <h4 class="font-bold dark:text-white">محمود كمال</h4>
                            <p class="text-xs text-slate-500">طبيب صيدلي</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer is included in Layout -->
@endsection
