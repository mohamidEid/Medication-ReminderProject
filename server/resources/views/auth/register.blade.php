@extends('layouts.app')

@section('title', 'إنشاء حساب جديد')

@section('content')
    <div class="min-h-screen pt-20 flex items-center justify-center p-4 relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute top-0 left-0 w-full h-full -z-10">
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl animate-float"
                style="animation-delay: 2s"></div>
        </div>

        <div
            class="w-full max-w-5xl bg-white dark:bg-slate-900 rounded-[2rem] shadow-2xl overflow-hidden flex flex-col md:flex-row animate-in border border-slate-100 dark:border-slate-800">

            <!-- Right Side: Decorative Image (Hidden on Mobile) -->
            <div
                class="hidden md:block w-1/2 bg-gradient-to-br from-indigo-600 to-purple-700 p-12 relative overflow-hidden text-white">
                <div
                    class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')] bg-cover bg-center mix-blend-overlay opacity-20">
                </div>
                <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-t from-indigo-900/50 to-transparent"></div>

                <div class="relative z-10 h-full flex flex-col justify-center items-center text-center">
                    <div
                        class="w-24 h-24 bg-white/20 backdrop-blur-lg rounded-3xl flex items-center justify-center mb-8 animate-float">
                        <i data-lucide="heart-pulse" class="w-12 h-12 text-white"></i>
                    </div>

                    <h3 class="text-3xl font-bold mb-4">انضم لعائلة MediRemind</h3>
                    <p class="text-indigo-100 text-lg leading-relaxed max-w-sm">
                        ابدأ رحلتك نحو صحة أفضل اليوم. سجل مجاناً واستمتع بكل المميزات.
                    </p>

                    <div class="mt-8 flex gap-4">
                        <div class="bg-white/10 backdrop-blur-sm p-4 rounded-xl">
                            <h4 class="font-bold text-2xl">مجاني</h4>
                            <p class="text-xs text-indigo-200">مدى الحياة</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm p-4 rounded-xl">
                            <h4 class="font-bold text-2xl">+1k</h4>
                            <p class="text-xs text-indigo-200">مستخدم</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Left Side: Register Form -->
            <div class="w-full md:w-1/2 p-8 md:p-12">
                <div class="flex items-center gap-2 mb-8">
                    <i data-lucide="pill" class="w-8 h-8 text-indigo-600"></i>
                    <span class="text-2xl font-bold text-slate-800 dark:text-white">MediRemind</span>
                </div>

                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-slate-800 dark:text-white mb-2">إنشاء حساب جديد</h2>
                    <p class="text-slate-500 dark:text-slate-400">املأ البيانات التالية للبدء</p>
                </div>

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">الاسم الكامل</label>
                        <div class="relative">
                            <i data-lucide="user"
                                class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>
                            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                                class="w-full pr-12 pl-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all"
                                placeholder="محمد أحمد">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">البريد
                            الإلكتروني</label>
                        <div class="relative">
                            <i data-lucide="mail"
                                class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full pr-12 pl-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all"
                                placeholder="your@email.com">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">كلمة المرور</label>
                        <div class="relative">
                            <i data-lucide="lock"
                                class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>
                            <input type="password" name="password" required
                                class="w-full pr-12 pl-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all"
                                placeholder="••••••••">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">تأكيد كلمة
                            المرور</label>
                        <div class="relative">
                            <i data-lucide="check-circle"
                                class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>
                            <input type="password" name="password_confirmation" required
                                class="w-full pr-12 pl-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all"
                                placeholder="••••••••">
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="w-full py-4 rounded-xl bg-indigo-600 text-white font-bold text-lg hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 dark:shadow-none flex items-center justify-center gap-2 group">
                            <span>إنشاء الحساب</span>
                            <i data-lucide="arrow-left" class="w-5 h-5 group-hover:-translate-x-1 transition-transform"></i>
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center text-slate-500 dark:text-slate-400">
                    لديك حساب بالفعل؟
                    <a href="{{ route('login') }}"
                        class="text-indigo-600 dark:text-indigo-400 font-bold hover:underline">تسجيل الدخول</a>
                </div>
            </div>
        </div>
    </div>
@endsection
