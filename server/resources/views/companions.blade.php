@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6 pt-24" dir="rtl">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">👥 المرافقين وأفراد العائلة</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">دع أفراد عائلتك يساعدونك في متابعة علاجك</p>
        </div>

        <!-- إضافة مرافق جديد -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">➕ إضافة مرافق جديد</h2>

            <form id="inviteForm" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">البريد الإلكتروني
                        للمرافق</label>
                    <input type="email" id="companionEmail" required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500"
                        placeholder="example@email.com">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">سيتم إرسال دعوة لهذا البريد</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">العلاقة (اختياري)</label>
                    <select id="relationship"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg">
                        <option value="">اختر...</option>
                        <option value="mother">الأم</option>
                        <option value="father">الأب</option>
                        <option value="son">الابن</option>
                        <option value="daughter">الابنة</option>
                        <option value="wife">الزوجة</option>
                        <option value="husband">الزوج</option>
                        <option value="brother">الأخ</option>
                        <option value="sister">الأخت</option>
                        <option value="friend">صديق</option>
                        <option value="caregiver">مقدم رعاية</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الصلاحيات</label>
                    <div class="space-y-2">
                        <label class="flex items-center text-gray-700 dark:text-gray-300">
                            <input type="checkbox" name="permissions" value="view_medications" checked
                                class="rounded text-blue-600">
                            <span class="mr-2">عرض الأدوية</span>
                        </label>
                        <label class="flex items-center text-gray-700 dark:text-gray-300">
                            <input type="checkbox" name="permissions" value="view_doses" checked
                                class="rounded text-blue-600">
                            <span class="mr-2">عرض الجرعات</span>
                        </label>
                        <label class="flex items-center text-gray-700 dark:text-gray-300">
                            <input type="checkbox" name="permissions" value="receive_alerts" checked
                                class="rounded text-blue-600">
                            <span class="mr-2">استلام التنبيهات</span>
                        </label>
                        <label class="flex items-center text-gray-700 dark:text-gray-300">
                            <input type="checkbox" name="permissions" value="manage_medications"
                                class="rounded text-blue-600">
                            <span class="mr-2">إدارة الأدوية</span>
                        </label>
                    </div>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 w-full">
                    📨 إرسال دعوة
                </button>
            </form>
        </div>

        <!-- قائمة المرافقين -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">قائمة المرافقين</h2>

            <div id="companionsList" class="space-y-3">
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">جاري التحميل...</p>
            </div>
        </div>

        <!-- الدعوات المعلقة -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">الدعوات المعلقة</h2>

            <div id="pendingInvitations" class="space-y-3">
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">لا توجد دعوات معلقة</p>
            </div>
        </div>
    </div>

    <script>
        // CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        // إرسال دعوة
        document.getElementById('inviteForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const email = document.getElementById('companionEmail').value;
            const relationship = document.getElementById('relationship').value;

            // جمع الصلاحيات
            const permissions = [];
            document.querySelectorAll('input[name="permissions"]:checked').forEach(checkbox => {
                permissions.push(checkbox.value);
            });

            try {
                const response = await fetch('/api/companions/invite', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({
                        email: email,
                        relationship: relationship || null,
                        permissions: permissions
                    })
                });

                const result = await response.json();

                if (result.success) {
                    alert('✅ ' + result.message);
                    document.getElementById('inviteForm').reset();
                    loadCompanions();
                } else {
                    alert('❌ ' + result.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('حدث خطأ أثناء إرسال الدعوة');
            }
        });

        // تحميل المرافقين
        async function loadCompanions() {
            try {
                const response = await fetch('/api/companions', {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    credentials: 'same-origin'
                });

                const result = await response.json();

                if (result.success) {
                    displayCompanions(result.data);
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        // عرض المرافقين
        function displayCompanions(companions) {
            const acceptedList = document.getElementById('companionsList');
            const pendingList = document.getElementById('pendingInvitations');

            const accepted = companions.filter(c => c.status === 'accepted');
            const pending = companions.filter(c => c.status === 'pending');

            // المرافقين المقبولين
            if (accepted.length === 0) {
                acceptedList.innerHTML =
                    '<p class="text-gray-500 dark:text-gray-400 text-center py-4">لا يوجد مرافقين حالياً</p>';
            } else {
                acceptedList.innerHTML = accepted.map(companion => `
            <div class="border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 rounded-lg p-4 flex justify-between items-center">
                <div>
                    <h4 class="font-semibold text-gray-900 dark:text-white">${companion.companion?.name || companion.companion?.email}</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">${companion.companion?.email}</p>
                    ${companion.relationship ? `<p class="text-sm text-gray-500 dark:text-gray-400">${translateRelationship(companion.relationship)}</p>` : ''}
                    <div class="flex gap-2 mt-2">
                        ${(companion.permissions || []).map(p => `
                                    <span class="text-xs bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-2 py-1 rounded">${translatePermission(p)}</span>
                                `).join('')}
                    </div>
                </div>
                <div>
                    <button onclick="removeCompanion(${companion.id})" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 text-sm">
                        🗑️ إزالة
                    </button>
                </div>
            </div>
        `).join('');
            }

            // الدعوات المعلقة
            if (pending.length === 0) {
                pendingList.innerHTML =
                    '<p class="text-gray-500 dark:text-gray-400 text-center py-4">لا توجد دعوات معلقة</p>';
            } else {
                pendingList.innerHTML = pending.map(companion => `
            <div class="border border-yellow-300 dark:border-yellow-700 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white">${companion.companion?.email}</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">بانتظار القبول</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">تم الإرسال: ${formatDate(companion.invitation_sent_at)}</p>
                    </div>
                    <span class="bg-yellow-200 dark:bg-yellow-700 text-yellow-800 dark:text-yellow-200 px-3 py-1 rounded-full text-sm">معلق</span>
                </div>
            </div>
        `).join('');
            }
        }

        // إزالة مرافق
        async function removeCompanion(id) {
            if (!confirm('هل أنت متأكد من إزالة هذا المرافق؟')) return;

            try {
                const response = await fetch(`/api/companions/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    credentials: 'same-origin'
                });

                const result = await response.json();

                if (result.success) {
                    alert('✅ تم الإزالة بنجاح');
                    loadCompanions();
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        // Helper functions
        function translateRelationship(rel) {
            const translations = {
                'mother': 'الأم',
                'father': 'الأب',
                'son': 'الابن',
                'daughter': 'الابنة',
                'wife': 'الزوجة',
                'husband': 'الزوج',
                'brother': 'الأخ',
                'sister': 'الأخت',
                'friend': 'صديق',
                'caregiver': 'مقدم رعاية'
            };
            return translations[rel] || rel;
        }

        function translatePermission(perm) {
            const translations = {
                'view_medications': 'عرض الأدوية',
                'view_doses': 'عرض الجرعات',
                'receive_alerts': 'استلام التنبيهات',
                'manage_medications': 'إدارة الأدوية'
            };
            return translations[perm] || perm;
        }

        function formatDate(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            return date.toLocaleDateString('ar-EG');
        }

        // تحميل البيانات عند فتح الصفحة
        document.addEventListener('DOMContentLoaded', loadCompanions);
    </script>
@endsection
