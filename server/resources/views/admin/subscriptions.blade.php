@extends('layouts.dashboard')

@section('title', 'إدارة الاشتراكات')
@section('header', 'إدارة الاشتراكات')

@section('content')
    <div class="space-y-8">

        <!-- Filters -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-800">
            <div class="flex gap-4">
                <select
                    class="px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white">
                    <option value="">جميع الحالات</option>
                    <option value="pending">قيد المراجعة</option>
                    <option value="approved">مقبولة</option>
                    <option value="rejected">مرفوضة</option>
                </select>
            </div>
        </div>

        <!-- Receipts List -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-8 shadow-sm border border-slate-100 dark:border-slate-800">
            <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6">طلبات الاشتراك</h3>

            <div class="space-y-4">
                @forelse($receipts as $receipt)
                    <div
                        class="border border-slate-200 dark:border-slate-700 rounded-xl p-6 hover:shadow-lg transition-shadow">
                        <div class="flex items-start justify-between gap-6">
                            <!-- User Info -->
                            <div class="flex items-start gap-4 flex-1">
                                <div
                                    class="w-16 h-16 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 rounded-xl flex items-center justify-center font-bold text-xl">
                                    {{ strtoupper(substr($receipt->user->name, 0, 1)) }}
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-lg text-slate-900 dark:text-white">{{ $receipt->user->name }}
                                    </h4>
                                    <p class="text-sm text-slate-600 dark:text-slate-400">{{ $receipt->user->email }}</p>
                                    <p class="text-sm text-slate-500 dark:text-slate-500 mt-1">رقم الهاتف:
                                        {{ $receipt->phone }}</p>
                                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-2">تم الإرسال:
                                        {{ $receipt->created_at->format('Y-m-d H:i') }}</p>

                                    @if ($receipt->notes)
                                        <div class="mt-3 p-3 bg-slate-50 dark:bg-slate-800 rounded-lg">
                                            <p class="text-sm text-slate-700 dark:text-slate-300"><strong>ملاحظات:</strong>
                                                {{ $receipt->notes }}</p>
                                        </div>
                                    @endif

                                    @if ($receipt->status === 'rejected' && $receipt->admin_notes)
                                        <div
                                            class="mt-3 p-3 bg-rose-50 dark:bg-rose-900/20 rounded-lg border border-rose-200 dark:border-rose-800">
                                            <p class="text-sm text-rose-700 dark:text-rose-300"><strong>سبب الرفض:</strong>
                                                {{ $receipt->admin_notes }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Status & Actions -->
                            <div class="text-left space-y-4">
                                <!-- Status Badge -->
                                @if ($receipt->status === 'pending')
                                    <span
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-50 dark:bg-yellow-900/20 text-yellow-700 dark:text-yellow-300 rounded-xl font-bold border border-yellow-200 dark:border-yellow-800">
                                        <i data-lucide="clock" class="w-4 h-4"></i>
                                        قيد المراجعة
                                    </span>
                                @elseif($receipt->status === 'approved')
                                    <span
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 rounded-xl font-bold border border-green-200 dark:border-green-800">
                                        <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                                        مقبول
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-rose-50 dark:bg-rose-900/20 text-rose-700 dark:text-rose-300 rounded-xl font-bold border border-rose-200 dark:border-rose-800">
                                        <i data-lucide="x-circle" class="w-4 h-4"></i>
                                        مرفوض
                                    </span>
                                @endif

                                <!-- Receipt Image -->
                                <a href="{{ asset('storage/' . $receipt->receipt_path) }}" target="_blank"
                                    class="block w-48 h-32 rounded-lg overflow-hidden border-2 border-slate-200 dark:border-slate-700 hover:border-indigo-500 transition-colors">
                                    <img src="{{ asset('storage/' . $receipt->receipt_path) }}" alt="Receipt"
                                        class="w-full h-full object-cover">
                                </a>

                                <!-- Actions -->
                                @if ($receipt->status === 'pending')
                                    <div class="flex gap-2">
                                        <form action="{{ route('admin.subscriptions.approve', $receipt) }}" method="POST"
                                            class="flex-1">
                                            @csrf
                                            <button type="submit"
                                                class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-bold transition-colors flex items-center justify-center gap-2">
                                                <i data-lucide="check" class="w-4 h-4"></i>
                                                موافقة
                                            </button>
                                        </form>

                                        <button onclick="showRejectModal({{ $receipt->id }})"
                                            class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg font-bold transition-colors">
                                            <i data-lucide="x" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                @endif

                                @if ($receipt->reviewed_at)
                                    <p class="text-xs text-slate-500 dark:text-slate-400">
                                        تمت المراجعة: {{ $receipt->reviewed_at->format('Y-m-d H:i') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Reject Modal -->
                    <div id="rejectModal{{ $receipt->id }}"
                        class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
                        <div class="bg-white dark:bg-slate-900 rounded-2xl p-8 max-w-md w-full">
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4">رفض الاشتراك</h3>
                            <form action="{{ route('admin.subscriptions.reject', $receipt) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">سبب
                                        الرفض</label>
                                    <textarea name="admin_notes" rows="4" required
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-rose-500/50 outline-none"></textarea>
                                </div>
                                <div class="flex gap-3">
                                    <button type="submit"
                                        class="flex-1 px-6 py-3 bg-rose-600 hover:bg-rose-700 text-white rounded-xl font-bold">
                                        رفض
                                    </button>
                                    <button type="button" onclick="hideRejectModal({{ $receipt->id }})"
                                        class="px-6 py-3 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl font-bold">
                                        إلغاء
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <i data-lucide="inbox" class="w-16 h-16 mx-auto text-slate-300 dark:text-slate-700 mb-4"></i>
                        <p class="text-slate-500 dark:text-slate-400">لا توجد طلبات اشتراك</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $receipts->links() }}
            </div>
        </div>
    </div>

    <script>
        function showRejectModal(id) {
            document.getElementById('rejectModal' + id).classList.remove('hidden');
        }

        function hideRejectModal(id) {
            document.getElementById('rejectModal' + id).classList.add('hidden');
        }
    </script>
@endsection
