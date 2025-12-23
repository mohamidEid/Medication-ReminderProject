@extends('layouts.dashboard')

@section('title', 'الإعدادات')
@section('header', 'الإعدادات')

@section('content')
    <div class="space-y-8" x-data="{ activeTab: 'profile' }">

        <!-- Tabs Navigation -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-2 shadow-sm border border-slate-100 dark:border-slate-800">
            <div class="flex gap-2 overflow-x-auto">
                <button @click="activeTab = 'profile'"
                    :class="activeTab === 'profile' ?
                        'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400' :
                        'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800'"
                    class="px-6 py-3 rounded-xl font-bold transition-all flex items-center gap-2 whitespace-nowrap">
                    <i data-lucide="user" class="w-5 h-5"></i>
                    <span>الملف الشخصي</span>
                </button>

                <button @click="activeTab = 'notifications'"
                    :class="activeTab === 'notifications' ?
                        'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400' :
                        'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800'"
                    class="px-6 py-3 rounded-xl font-bold transition-all flex items-center gap-2 whitespace-nowrap">
                    <i data-lucide="bell" class="w-5 h-5"></i>
                    <span>الإشعارات</span>
                </button>

                <button @click="activeTab = 'security'"
                    :class="activeTab === 'security' ?
                        'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400' :
                        'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800'"
                    class="px-6 py-3 rounded-xl font-bold transition-all flex items-center gap-2 whitespace-nowrap">
                    <i data-lucide="shield" class="w-5 h-5"></i>
                    <span>الأمان</span>
                </button>
            </div>
        </div>

        <!-- Profile Tab -->
        <div x-show="activeTab === 'profile'" x-transition class="space-y-6">
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-8 shadow-sm border border-slate-100 dark:border-slate-800">
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                    <i data-lucide="user-circle" class="w-6 h-6 text-indigo-500"></i>
                    معلومات الحساب
                </h3>

                <form action="{{ route('settings.update-profile') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">الاسم
                                الكامل</label>
                            <input type="text" name="name" value="{{ Auth::user()->name }}" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">البريد
                                الإلكتروني</label>
                            <input type="email" name="email" value="{{ Auth::user()->email }}" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">رقم
                                الهاتف</label>
                            <input type="tel" name="phone" value="{{ Auth::user()->phone ?? '' }}"
                                placeholder="+20 123 456 7890"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">تاريخ
                                الميلاد</label>
                            <input type="date" name="birth_date" value="{{ Auth::user()->birth_date ?? '' }}"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all">
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <button type="submit"
                            class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold transition-all shadow-lg shadow-indigo-200 dark:shadow-none">
                            حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Notifications Tab -->
        <div x-show="activeTab === 'notifications'" x-transition class="space-y-6">
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-8 shadow-sm border border-slate-100 dark:border-slate-800">
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                    <i data-lucide="bell-ring" class="w-6 h-6 text-indigo-500"></i>
                    إعدادات الإشعارات
                </h3>

                <form action="{{ route('settings.update-notifications') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800/50 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-blue-50 dark:bg-blue-900/20 text-blue-600 rounded-lg flex items-center justify-center">
                                    <i data-lucide="smartphone" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 dark:text-white">إشعارات التطبيق</h4>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">تلقي إشعارات داخل التطبيق</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="app_notifications" checked class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-indigo-600">
                                </div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800/50 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-green-50 dark:bg-green-900/20 text-green-600 rounded-lg flex items-center justify-center">
                                    <i data-lucide="mail" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 dark:text-white">إشعارات البريد الإلكتروني</h4>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">تلقي رسائل تذكير عبر البريد</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="email_notifications" checked class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-indigo-600">
                                </div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800/50 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-purple-50 dark:bg-purple-900/20 text-purple-600 rounded-lg flex items-center justify-center">
                                    <i data-lucide="message-circle" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 dark:text-white">إشعارات SMS</h4>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">تلقي رسائل نصية قصيرة</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="sms_notifications" class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-indigo-600">
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <button type="submit"
                            class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold transition-all shadow-lg shadow-indigo-200 dark:shadow-none">
                            حفظ الإعدادات
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Security Tab -->
        <div x-show="activeTab === 'security'" x-transition class="space-y-6">
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl p-8 shadow-sm border border-slate-100 dark:border-slate-800">
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                    <i data-lucide="lock" class="w-6 h-6 text-indigo-500"></i>
                    تغيير كلمة المرور
                </h3>

                <form action="{{ route('settings.update-password') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">كلمة المرور
                                الحالية</label>
                            <input type="password" name="current_password" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">كلمة المرور
                                الجديدة</label>
                            <input type="password" name="password" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">تأكيد كلمة
                                المرور</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all">
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <button type="submit"
                            class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold transition-all shadow-lg shadow-indigo-200 dark:shadow-none">
                            تحديث كلمة المرور
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
