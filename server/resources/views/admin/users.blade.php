@extends('layouts.dashboard')

@section('title', 'إدارة المستخدمين')
@section('header', 'إدارة المستخدمين')

@section('content')
    <div class="space-y-8">

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div
                class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-2xl p-6 border border-indigo-200 dark:border-indigo-800">
                <div class="flex items-center justify-between mb-2">
                    <i data-lucide="users" class="w-8 h-8 text-indigo-600"></i>
                    <span class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ $users->total() }}</span>
                </div>
                <h3 class="text-lg font-bold text-indigo-900 dark:text-indigo-100">إجمالي المستخدمين</h3>
            </div>

            <div
                class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-2xl p-6 border border-green-200 dark:border-green-800">
                <div class="flex items-center justify-between mb-2">
                    <i data-lucide="user-check" class="w-8 h-8 text-green-600"></i>
                    <span
                        class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $users->where('email_verified_at', '!=', null)->count() }}</span>
                </div>
                <h3 class="text-lg font-bold text-green-900 dark:text-green-100">مستخدمين مفعّلين</h3>
            </div>

            <div
                class="bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 rounded-2xl p-6 border border-blue-200 dark:border-blue-800">
                <div class="flex items-center justify-between mb-2">
                    <i data-lucide="shield-check" class="w-8 h-8 text-blue-600"></i>
                    <span
                        class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $users->where('is_admin', true)->count() }}</span>
                </div>
                <h3 class="text-lg font-bold text-blue-900 dark:text-blue-100">المديرين</h3>
            </div>
        </div>

        <!-- Users Table -->
        <div
            class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
            <div class="p-6 border-b border-slate-100 dark:border-slate-800">
                <h3 class="text-xl font-bold text-slate-800 dark:text-white">قائمة المستخدمين</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-800">
                        <tr>
                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-600 dark:text-slate-400 uppercase">
                                المستخدم</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-600 dark:text-slate-400 uppercase">
                                البريد</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-600 dark:text-slate-400 uppercase">
                                الأدوية</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-600 dark:text-slate-400 uppercase">
                                الاشتراك</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-600 dark:text-slate-400 uppercase">
                                تاريخ التسجيل</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-600 dark:text-slate-400 uppercase">
                                الحالة</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($users as $user)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 rounded-full flex items-center justify-center font-bold">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-900 dark:text-white">{{ $user->name }}</p>
                                            @if ($user->is_admin)
                                                <span
                                                    class="text-xs px-2 py-0.5 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 rounded-full">مدير</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-400">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center gap-1 px-3 py-1 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-300 rounded-lg font-medium">
                                        <i data-lucide="pill" class="w-4 h-4"></i>
                                        {{ $user->medicines_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($user->subscriptions->where('status', 'active')->first())
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 rounded-lg font-medium">
                                            <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                                            نشط
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 rounded-lg font-medium">
                                            <i data-lucide="x-circle" class="w-4 h-4"></i>
                                            غير مشترك
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-400 text-sm">
                                    {{ $user->created_at->format('Y-m-d') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($user->email_verified_at)
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 rounded-lg text-sm font-medium">
                                            <i data-lucide="shield-check" class="w-3 h-3"></i>
                                            مفعّل
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-50 dark:bg-yellow-900/20 text-yellow-700 dark:text-yellow-300 rounded-lg text-sm font-medium">
                                            <i data-lucide="alert-circle" class="w-3 h-3"></i>
                                            غير مفعّل
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-6 border-t border-slate-100 dark:border-slate-800">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
