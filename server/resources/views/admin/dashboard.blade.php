@extends('layouts.dashboard')

@section('title', 'لوحة تحكم المدير')
@section('header', 'لوحة تحكم المدير')

@section('content')
    <div class="space-y-8">

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div
                class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-2xl p-6 border border-indigo-200 dark:border-indigo-800">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-indigo-600 text-white rounded-xl flex items-center justify-center shadow-lg">
                        <i data-lucide="users" class="w-6 h-6"></i>
                    </div>
                    <span class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ $stats['total_users'] }}</span>
                </div>
                <h3 class="text-lg font-bold text-indigo-900 dark:text-indigo-100">إجمالي المستخدمين</h3>
            </div>

            <div
                class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-2xl p-6 border border-green-200 dark:border-green-800">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-600 text-white rounded-xl flex items-center justify-center shadow-lg">
                        <i data-lucide="check-circle-2" class="w-6 h-6"></i>
                    </div>
                    <span
                        class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $stats['active_subscriptions'] }}</span>
                </div>
                <h3 class="text-lg font-bold text-green-900 dark:text-green-100">الاشتراكات النشطة</h3>
            </div>

            <div
                class="bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 rounded-2xl p-6 border border-yellow-200 dark:border-yellow-800">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-yellow-600 text-white rounded-xl flex items-center justify-center shadow-lg animate-pulse">
                        <i data-lucide="clock" class="w-6 h-6"></i>
                    </div>
                    <span
                        class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">{{ $stats['pending_receipts'] }}</span>
                </div>
                <h3 class="text-lg font-bold text-yellow-900 dark:text-yellow-100">قيد المراجعة</h3>
            </div>

            <div
                class="bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 rounded-2xl p-6 border border-blue-200 dark:border-blue-800">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-600 text-white rounded-xl flex items-center justify-center shadow-lg">
                        <i data-lucide="wallet" class="w-6 h-6"></i>
                    </div>
                    <span class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['total_revenue'] }}</span>
                </div>
                <h3 class="text-lg font-bold text-blue-900 dark:text-blue-100">الإيرادات (جنيه)</h3>
            </div>
        </div>

        <!-- Pending Receipts -->
        @if ($pendingReceipts->count() > 0)
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-8 shadow-sm border border-slate-100 dark:border-slate-800">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white flex items-center gap-2">
                        <i data-lucide="alert-circle" class="w-6 h-6 text-yellow-500"></i>
                        طلبات الاشتراك المعلقة
                    </h3>
                    <a href="{{ route('admin.subscriptions') }}"
                        class="text-indigo-600 dark:text-indigo-400 hover:underline font-medium">
                        عرض الكل
                    </a>
                </div>

                <div class="space-y-4">
                    @foreach ($pendingReceipts as $receipt)
                        <div
                            class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800 rounded-xl hover:shadow-md transition-shadow">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 rounded-xl flex items-center justify-center font-bold">
                                    {{ strtoupper(substr($receipt->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 dark:text-white">{{ $receipt->user->name }}</h4>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">{{ $receipt->user->email }}</p>
                                    <p class="text-xs text-slate-400 dark:text-slate-500">
                                        {{ $receipt->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ asset('storage/' . $receipt->receipt_path) }}" target="_blank"
                                    class="px-4 py-2 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-colors">
                                    عرض الإيصال
                                </a>
                                <form action="{{ route('admin.subscriptions.approve', $receipt) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                        موافقة
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Recent Users -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-8 shadow-sm border border-slate-100 dark:border-slate-800">
            <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                <i data-lucide="user-plus" class="w-6 h-6 text-indigo-500"></i>
                أحدث المستخدمين
            </h3>

            <div class="space-y-3">
                @foreach ($recentUsers as $user)
                    <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800 rounded-xl">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 rounded-full flex items-center justify-center font-bold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-medium text-slate-900 dark:text-white">{{ $user->name }}</p>
                                <p class="text-sm text-slate-500 dark:text-slate-400">{{ $user->email }}</p>
                            </div>
                        </div>
                        <span
                            class="text-xs text-slate-400 dark:text-slate-500">{{ $user->created_at->diffForHumans() }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
