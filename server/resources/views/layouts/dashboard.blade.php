<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MediRemind') }} | @yield('title', 'لوحة التحكم')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Cairo', 'Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Dark Mode Script -->
    <script>
        if (localStorage.darkMode === 'true') {
            document.documentElement.classList.add('dark');
        }

        window.toggleDark = function() {
            const html = document.documentElement;
            const isDark = html.classList.toggle('dark');
            localStorage.darkMode = isDark.toString();

            document.querySelectorAll('[data-dark-toggle]').forEach(btn => {
                btn.textContent = isDark ? '☀️' : '🌙';
            });
        };
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Cairo', 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="hidden lg:flex lg:flex-shrink-0">
            <div class="flex flex-col w-64 bg-white dark:bg-slate-900 border-l border-slate-200 dark:border-slate-800">
                <!-- Sidebar Header -->
                <div class="flex items-center justify-center h-20 border-b border-slate-200 dark:border-slate-800">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center">
                            <span class="text-white font-bold text-xl">M</span>
                        </div>
                        <span
                            class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">MediRemind</span>
                    </a>
                </div>

                <!-- Sidebar Navigation -->
                <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-2">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('dashboard') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-colors">
                        <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                        <span>نظرة عامة</span>
                    </a>

                    <a href="{{ route('medicines.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('medicines.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-colors">
                        <i data-lucide="pill" class="w-5 h-5"></i>
                        <span>أدويتي</span>
                    </a>

                    <a href="{{ route('schedule') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('schedule') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-colors">
                        <i data-lucide="calendar" class="w-5 h-5"></i>
                        <span>الجدول الزمني</span>
                    </a>

                    <a href="{{ route('history') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('history') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-colors">
                        <i data-lucide="history" class="w-5 h-5"></i>
                        <span>السجل</span>
                    </a>

                    <a href="{{ route('subscription.create') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('subscription.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-colors">
                        <i data-lucide="credit-card" class="w-5 h-5"></i>
                        <span>الاشتراك</span>
                    </a>

                    <a href="{{ route('settings') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('settings') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-colors">
                        <i data-lucide="settings" class="w-5 h-5"></i>
                        <span>الإعدادات</span>
                    </a>

                    @if (Auth::check() && Auth::user()->is_admin)
                        <p class="px-4 text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 mt-6">إدارة النظام
                        </p>
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-colors">
                            <i data-lucide="shield-check" class="w-5 h-5"></i>
                            <span>لوحة المدير</span>
                        </a>
                    @endif
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 h-20">
                <div class="h-full px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-slate-900 dark:text-white">@yield('title', 'لوحة التحكم')</h1>

                    <div class="flex items-center gap-3">
                        <!-- Dark Mode Toggle -->
                        <button data-dark-toggle
                            class="w-10 h-10 rounded-xl flex items-center justify-center text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors text-xl">
                            🌙
                        </button>

                        <!-- Notifications -->
                        <button
                            class="w-10 h-10 rounded-xl flex items-center justify-center text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors relative">
                            <i data-lucide="bell" class="w-5 h-5"></i>
                            <span class="absolute top-2 left-2 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>

                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                                <div class="text-right">
                                    <p class="text-sm font-medium text-slate-900 dark:text-white">
                                        {{ Auth::user()->name }}</p>
                                </div>
                                <div
                                    class="w-8 h-8 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-full flex items-center justify-center">
                                    <span
                                        class="text-white text-sm font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                            </button>

                            <div x-show="open" @click.away="open = false" x-transition
                                class="absolute left-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-xl shadow-lg py-1 z-50 border border-slate-200 dark:border-slate-700">
                                <a href="{{ route('settings') }}"
                                    class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700">
                                    الإعدادات
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-right px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-slate-100 dark:hover:bg-slate-700">
                                        تسجيل الخروج
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-slate-50 dark:bg-slate-950 p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        lucide.createIcons();

        document.addEventListener('DOMContentLoaded', function() {
            const isDark = document.documentElement.classList.contains('dark');
            document.querySelectorAll('[data-dark-toggle]').forEach(btn => {
                btn.textContent = isDark ? '☀️' : '🌙';
                btn.addEventListener('click', window.toggleDark);
            });
        });
    </script>
</body>

</html>
