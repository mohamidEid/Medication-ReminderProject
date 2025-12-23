@extends('layouts.app')

@section('title', 'تسجيل الدخول')

@section('content')
    <div class="min-h-screen flex items-center justify-center py-20 px-4 sm:px-6 lg:px-8 relative z-10">
        <div
            class="max-w-5xl w-full bg-white dark:bg-slate-900 rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row border border-slate-100 dark:border-slate-800">

            <!-- Login Form Side (On Right in RTL) -->
            <div class="md:w-1/2 p-8 md:p-12 flex flex-col justify-center bg-white dark:bg-slate-950 order-2 md:order-1">
                <div class="mb-10 text-center md:text-start">
                    <h3 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">تسجيل الدخول</h3>
                    <p class="text-slate-500 dark:text-slate-400">تابع رحلتك الصحية معنا</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    @if ($errors->any())
                        <div
                            class="bg-red-50 dark:bg-red-900/10 border border-red-100 dark:border-red-900/30 text-red-600 dark:text-red-400 px-4 py-3 rounded-xl text-sm flex items-center gap-2 mb-6">
                            <i data-lucide="alert-circle" class="w-5 h-5 shrink-0"></i>
                            <span>بيانات الدخول غير صحيحة.</span>
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">البريد
                            الإلكتروني</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="block w-full px-4 py-3.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all outline-none"
                            placeholder="example@mail.com">
                    </div>

                    <div>
                        <div class="flex justify-between mb-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">كلمة المرور</label>
                            <a href="{{ route('password.request') }}"
                                class="text-xs font-bold text-indigo-600 dark:text-indigo-400">نسيت؟</a>
                        </div>
                        <input type="password" name="password" required
                            class="block w-full px-4 py-3.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all outline-none"
                            placeholder="••••••••">
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="remember" id="remember"
                            class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="remember" class="text-sm text-slate-600 dark:text-slate-400">تذكر جهازي</label>
                    </div>

                    <button type="submit"
                        class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg transition-all flex items-center justify-center gap-2">
                        <span>دخول</span>
                        <i data-lucide="arrow-left" class="w-4 h-4 rotate-180 rtl:rotate-0"></i>
                    </button>

                    <!-- Magic Login Button -->
                    <a href="{{ url('/magic-login') }}"
                        class="block w-full text-center py-3 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-300 font-bold rounded-xl border border-indigo-100 dark:border-indigo-800 hover:bg-indigo-100 dark:hover:bg-indigo-900/40 transition-colors mt-4">
                        ⚡ دخول سريع (تجريبي)
                    </a>
                </form>

                <div class="mt-8 text-center text-sm text-slate-500 dark:text-slate-400">
                    جديد معنا؟
                    <a href="{{ route('register') }}"
                        class="font-bold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">أنشئ حساباً مجانياً</a>
                </div>
            </div>

            <!-- Visual Side (On Left in RTL) -->
            <div
                class="md:w-1/2 bg-gradient-to-br from-indigo-600 to-purple-700 p-12 text-center text-white flex flex-col justify-center items-center relative overflow-hidden order-1 md:order-2">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-20">
                </div>

                <div class="relative z-10 max-w-sm mx-auto">
                    <div
                        class="bg-white/20 w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-6 backdrop-blur-sm shadow-xl">
                        <i data-lucide="pill" class="w-10 h-10 text-white"></i>
                    </div>

                    <h2 class="text-4xl font-bold mb-4">MediRemind</h2>
                    <p class="text-indigo-100 text-lg mb-8 leading-relaxed">
                        منصتك الذكية لإدارة أدويتك ومتابعة حالتك الصحية بكل سهولة وأمان.
                    </p>

                    <div class="flex flex-wrap justify-center gap-3">
                        <span
                            class="px-3 py-1 bg-white/10 rounded-full text-sm backdrop-blur-sm border border-white/10">تذكير
                            ذكي</span>
                        <span
                            class="px-3 py-1 bg-white/10 rounded-full text-sm backdrop-blur-sm border border-white/10">سجلات
                            دقيقة</span>
                        <span class="px-3 py-1 bg-white/10 rounded-full text-sm backdrop-blur-sm border border-white/10">آمن
                            100%</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
