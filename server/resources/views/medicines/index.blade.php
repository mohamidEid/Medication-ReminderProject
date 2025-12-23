@extends('layouts.dashboard')

@section('title', 'أدويتي')
@section('header', 'أدويتي')

@section('content')
    <div x-data="{ addModalOpen: false, selectedFreq: 'daily', times: ['09:00'] }" class="space-y-8">

        <!-- Header Actions -->
        <div class="flex flex-col md:flex-row justify-between items-end md:items-center gap-4">
            <div class="w-full md:w-auto">
                <div class="relative group w-full md:w-72">
                    <i data-lucide="search"
                        class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                    <input type="text" placeholder="بحث عن دواء..."
                        class="w-full pr-10 pl-4 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all shadow-sm">
                </div>
            </div>

            <button @click="addModalOpen = true"
                class="w-full md:w-auto px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold flex items-center justify-center gap-2 transition-all shadow-lg shadow-indigo-200 dark:shadow-none hover:shadow-indigo-300 transform hover:-translate-y-0.5">
                <i data-lucide="plus" class="w-5 h-5"></i>
                <span>إضافة دواء جديد</span>
            </button>
        </div>

        @if (session('success'))
            <div
                class="p-4 rounded-xl bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-bold flex items-center gap-3 border border-green-100 dark:border-green-800 animate-in fade-in slide-in-from-top-2">
                <div class="bg-green-100 dark:bg-green-800/30 p-1.5 rounded-full">
                    <i data-lucide="check" class="w-4 h-4"></i>
                </div>
                {{ session('success') }}
            </div>
        @endif

        <!-- Medicines Grid -->
        @if ($medicines->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($medicines as $medicine)
                    <div
                        class="group bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden">

                        <!-- Decoration -->
                        <div
                            class="absolute -right-6 -top-6 w-24 h-24 bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500">
                        </div>

                        <!-- Actions (Delete) -->
                        <div
                            class="absolute top-4 left-4 opacity-0 group-hover:opacity-100 transition-all duration-200 transform translate-x-2 group-hover:translate-x-0">
                            <form action="{{ route('medicines.destroy', $medicine) }}" method="POST"
                                onsubmit="return confirm('هل أنت متأكد من حذف هذا الدواء؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="p-2 text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-lg transition-colors"
                                    title="حذف">
                                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                                </button>
                            </form>
                        </div>

                        <div class="relative z-10 flex gap-4 mb-6">
                            <div
                                class="w-14 h-14 bg-gradient-to-tr from-indigo-500 to-violet-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200 dark:shadow-none">
                                <i data-lucide="pill" class="w-7 h-7"></i>
                            </div>
                            <div>
                                <h3
                                    class="font-bold text-lg text-slate-800 dark:text-white mb-0.5 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                    {{ $medicine->name }}</h3>
                                <span
                                    class="bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-xs px-2 py-0.5 rounded-md font-bold">{{ $medicine->dosage }}</span>
                            </div>
                        </div>

                        <div class="space-y-3 relative z-10">
                            <div
                                class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-300 bg-slate-50 dark:bg-slate-800/50 p-3 rounded-xl border border-slate-100 dark:border-slate-800">
                                <i data-lucide="clock" class="w-5 h-5 text-indigo-500"></i>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach (json_decode($medicine->times) as $time)
                                        <span
                                            class="bg-white dark:bg-slate-700 px-2 py-0.5 rounded shadow-sm text-xs font-bold font-mono">{{ date('h:i A', strtotime($time)) }}</span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-300 px-3">
                                <i data-lucide="repeat" class="w-5 h-5 text-slate-400"></i>
                                <span class="font-medium">
                                    @if ($medicine->frequency == 'daily')
                                        يومياً
                                    @elseif($medicine->frequency == 'twice_daily')
                                        مرتين يومياً
                                    @elseif($medicine->frequency == 'three_times_daily')
                                        3 مرات يومياً
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div
                class="flex flex-col items-center justify-center py-24 bg-white dark:bg-slate-900 rounded-3xl border-2 border-dashed border-slate-200 dark:border-slate-800 text-center group">
                <div
                    class="w-20 h-20 bg-indigo-50 dark:bg-indigo-900/20 rounded-full flex items-center justify-center mb-6 text-indigo-500 group-hover:scale-110 transition-transform duration-300">
                    <i data-lucide="pill" class="w-10 h-10"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">قائمة الأدوية فارغة</h3>
                <p class="text-slate-500 dark:text-slate-400 max-w-sm mx-auto mb-8 leading-relaxed">لم تقم بإضافة أي أدوية
                    بعد. أضف أدويتك الآن لنقوم بتذكيرك بمواعيدها.</p>
                <button @click="addModalOpen = true"
                    class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold transition-all shadow-lg shadow-indigo-200 dark:shadow-none hover:shadow-indigo-300 hover:-translate-y-0.5 flex items-center gap-2">
                    <i data-lucide="plus-circle" class="w-5 h-5"></i>
                    <span>إضافة أول دواء</span>
                </button>
            </div>
        @endif

        <!-- Add Medicine Modal -->
        <div x-show="addModalOpen" style="display: none;" class="relative z-50">
            <!-- Backdrop -->
            <div x-show="addModalOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
                @click="addModalOpen = false"></div>

            <!-- Modal Panel -->
            <div class="fixed inset-0 z-50 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                    <div x-show="addModalOpen" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-slate-900 text-right shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-xl border border-slate-100 dark:border-slate-800">

                        <!-- Modal Header -->
                        <div
                            class="bg-slate-50 dark:bg-slate-800/50 px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                <i data-lucide="plus-circle" class="w-5 h-5 text-indigo-500"></i>
                                إضافة دواء جديد
                            </h3>
                            <button @click="addModalOpen = false"
                                class="text-slate-400 hover:text-slate-500 transition-colors">
                                <i data-lucide="x" class="w-6 h-6"></i>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <div class="p-6">
                            <form action="{{ route('medicines.store') }}" method="POST" class="space-y-5">
                                @csrf

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="col-span-2">
                                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">اسم
                                            الدواء</label>
                                        <input type="text" name="name" required placeholder="مثال: بانادول"
                                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all placeholder:text-slate-400">
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">الجرعة</label>
                                        <input type="text" name="dosage" required placeholder="مثال: 500mg"
                                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all placeholder:text-slate-400">
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">تاريخ
                                            البدء</label>
                                        <input type="date" name="start_date" value="{{ date('Y-m-d') }}" required
                                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all text-right">
                                    </div>
                                </div>

                                <div
                                    class="p-4 bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-slate-100 dark:border-slate-800">
                                    <div class="mb-4">
                                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">كم
                                            مرة في اليوم؟</label>
                                        <select name="frequency" x-model="selectedFreq"
                                            @change="if(selectedFreq === 'daily') times = ['09:00'];
                                                     else if(selectedFreq === 'twice_daily') times = ['09:00', '21:00'];
                                                     else if(selectedFreq === 'three_times_daily') times = ['09:00', '15:00', '21:00'];"
                                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all">
                                            <option value="daily">يومياً (مرة واحدة)</option>
                                            <option value="twice_daily">مرتين يومياً (كل 12 ساعة)</option>
                                            <option value="three_times_daily">3 مرات يومياً (كل 8 ساعات)</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">تحديد
                                            المواعيد</label>
                                        <div class="grid grid-cols-3 gap-2">
                                            <template x-for="(time, index) in times" :key="index">
                                                <div class="relative">
                                                    <input type="time" :name="'times[]'" x-model="times[index]"
                                                        required
                                                        class="w-full px-2 py-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-center font-bold ltr focus:ring-2 focus:ring-indigo-500/50 outline-none">
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">تعليمات
                                        إضافية (اختياري)</label>
                                    <textarea name="instructions" rows="2" placeholder="مثال: يؤخذ بعد الأكل"
                                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all placeholder:text-slate-400 resize-none"></textarea>
                                </div>

                                <div class="pt-2 flex gap-3">
                                    <button type="submit"
                                        class="flex-1 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 dark:shadow-none hover:shadow-indigo-300 transform hover:-translate-y-0.5">
                                        حفظ الدواء
                                    </button>
                                    <button type="button" @click="addModalOpen = false"
                                        class="px-6 py-3 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl font-bold hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                                        إلغاء
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
