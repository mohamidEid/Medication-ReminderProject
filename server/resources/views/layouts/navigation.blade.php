<nav x-data="{
    mobileMenuOpen: false,
    scrolled: false,
    userMenuOpen: false,
    darkMode: localStorage.getItem('darkMode') === 'true',
    toggleTheme() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('darkMode', this.darkMode);
        if (this.darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
}" x-init="if (darkMode) document.documentElement.classList.add('dark');" @scroll.window="scrolled = (window.pageYOffset > 20)"
    :class="{ 'bg-white/80 dark:bg-slate-900/80 backdrop-blur-md shadow-sm': scrolled, 'bg-transparent': !scrolled }"
    class="fixed w-full z-50 transition-all duration-300 top-0 left-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center gap-2">
                <a href="{{ url('/') }}" class="flex items-center gap-2">
                    <div class="bg-indigo-600 p-2 rounded-xl text-white">
                        <i data-lucide="pill" class="w-6 h-6"></i>
                    </div>
                    <span
                        class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">
                        MediRemind
                    </span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8 rtl:space-x-reverse">
                <a href="#features"
                    class="text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium transition-colors">المميزات</a>
                <a href="#pricing"
                    class="text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium transition-colors">الأسعار</a>
                <a href="#demo"
                    class="text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium transition-colors">عرض
                    توضيحي</a>
                <a href="#contact"
                    class="text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium transition-colors">تواصل
                    معنا</a>
            </div>

            <!-- Actions -->
            <div class="hidden md:flex items-center gap-4">
                <!-- Theme Toggle -->
                <button data-dark-toggle
                    class="p-2 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors text-xl">
                    🌙
                </button>

                @auth
                    <!-- Filament Admin Button (Admin Only) -->
                    @if (Auth::check() && Auth::user()->is_admin)
                        <a href="/admin" target="_blank"
                            class="px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white rounded-xl font-bold flex items-center gap-2 transition-all shadow-lg shadow-purple-200 dark:shadow-none transform hover:-translate-y-0.5">
                            <i data-lucide="shield-check" class="w-5 h-5"></i>
                            <span>Filament Admin</span>
                        </a>
                    @endif

                    <!-- User Menu -->
                    <div class="relative" @click.away="userMenuOpen = false">
                        <button @click="userMenuOpen = !userMenuOpen"
                            class="flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                            <div
                                class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                {{ strtoupper(substr(Auth::user()->email, 0, 1)) }}
                            </div>
                            <span
                                class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ Auth::user()->email }}</span>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-slate-500"></i>
                        </button>

                        <!-- Dropdown -->
                        <div x-show="userMenuOpen" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute left-0 mt-2 w-56 rounded-xl bg-white dark:bg-slate-800 shadow-xl border border-slate-200 dark:border-slate-700 py-2"
                            style="display: none;">
                            <div class="px-4 py-3 border-b border-slate-200 dark:border-slate-700">
                                <p class="text-sm font-medium text-slate-900 dark:text-white">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="{{ route('dashboard') }}"
                                class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 flex items-center gap-2">
                                <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                                لوحة التحكم
                            </a>
                            <a href="{{ route('smart-features') }}"
                                class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 flex items-center gap-2">
                                <i data-lucide="sparkles" class="w-4 h-4"></i>
                                المميزات الذكية ✨
                            </a>
                            <a href="{{ route('companions') }}"
                                class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 flex items-center gap-2">
                                <i data-lucide="users" class="w-4 h-4"></i>
                                المرافقين 👥
                            </a>
                            <a href="{{ route('settings') }}"
                                class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 flex items-center gap-2">
                                <i data-lucide="settings" class="w-4 h-4"></i>
                                الإعدادات
                            </a>
                            <div class="border-t border-slate-200 dark:border-slate-700 mt-2"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-right px-4 py-2 text-sm text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-900/20 flex items-center gap-2">
                                    <i data-lucide="log-out" class="w-4 h-4"></i>
                                    تسجيل الخروج
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="text-slate-600 dark:text-slate-300 font-medium hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                        تسجيل الدخول
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 dark:shadow-none">
                        ابدأ الآن
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center gap-2">
                <button @click="toggleTheme()" class="p-2 rounded-lg text-slate-600 dark:text-slate-300">
                    <i x-show="!darkMode" data-lucide="moon" class="w-5 h-5"></i>
                    <i x-show="darkMode" data-lucide="sun" class="w-5 h-5" style="display: none;"></i>
                </button>
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="text-slate-600 dark:text-slate-300 hover:text-indigo-600 transition-colors">
                    <i x-show="!mobileMenuOpen" data-lucide="menu" class="w-6 h-6"></i>
                    <i x-show="mobileMenuOpen" data-lucide="x" class="w-6 h-6" style="display: none;"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="md:hidden bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800 shadow-xl"
        style="display: none;">
        <div class="px-4 pt-2 pb-6 space-y-1">
            <a href="#features"
                class="block px-3 py-2 rounded-lg text-base font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800">المميزات</a>
            <a href="#pricing"
                class="block px-3 py-2 rounded-lg text-base font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800">الأسعار</a>
            <a href="#demo"
                class="block px-3 py-2 rounded-lg text-base font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800">عرض
                توضيحي</a>
            <a href="#contact"
                class="block px-3 py-2 rounded-lg text-base font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800">تواصل
                معنا</a>

            <div class="pt-4 flex flex-col gap-3">
                @auth
                    <div class="px-3 py-2 bg-slate-100 dark:bg-slate-800 rounded-lg">
                        <p class="text-sm font-medium text-slate-900 dark:text-white">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ Auth::user()->email }}</p>
                    </div>
                    <a href="{{ route('dashboard') }}"
                        class="w-full text-center px-6 py-3 rounded-xl bg-indigo-600 text-white font-semibold shadow-lg">
                        لوحة التحكم
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-center px-6 py-3 rounded-xl border border-rose-200 dark:border-rose-800 text-rose-600 dark:text-rose-400 font-semibold">
                            تسجيل الخروج
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="w-full text-center px-6 py-3 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-semibold">
                        تسجيل الدخول
                    </a>
                    <a href="{{ route('register') }}"
                        class="w-full text-center px-6 py-3 rounded-xl bg-indigo-600 text-white font-semibold shadow-lg">
                        ابدأ الآن
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
