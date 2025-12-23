@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6 pt-24" dir="rtl">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">المميزات الذكية</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">مميزات ذكية لمساعدتك في إدارة الأدوية بشكل أفضل</p>
        </div>

        <!-- إحصائيات سريعة -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm">إجمالي الأدوية</p>
                        <h3 class="text-3xl font-bold mt-2" id="total-medicines">-</h3>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm">الجرعات اليوم</p>
                        <h3 class="text-3xl font-bold mt-2" id="today-doses">-</h3>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-100 text-sm">تنبيهات نشطة</p>
                        <h3 class="text-3xl font-bold mt-2" id="active-alerts">-</h3>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm">أدوية منخفضة</p>
                        <h3 class="text-3xl font-bold mt-2" id="low-stock-count">-</h3>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- إجراءات سريعة -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">⚡ إجراءات سريعة</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <a href="/medicines/create"
                    class="flex flex-col items-center p-4 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition-colors">
                    <div class="bg-blue-500 text-white p-3 rounded-full mb-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">إضافة دواء</span>
                </a>

                <a href="/medicines"
                    class="flex flex-col items-center p-4 bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/30 rounded-lg transition-colors">
                    <div class="bg-green-500 text-white p-3 rounded-full mb-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">إدارة الأدوية</span>
                </a>

                <a href="/companions"
                    class="flex flex-col items-center p-4 bg-purple-50 dark:bg-purple-900/20 hover:bg-purple-100 dark:hover:bg-purple-900/30 rounded-lg transition-colors">
                    <div class="bg-purple-500 text-white p-3 rounded-full mb-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">المرافقين</span>
                </a>

                <a href="/history"
                    class="flex flex-col items-center p-4 bg-orange-50 dark:bg-orange-900/20 hover:bg-orange-100 dark:hover:bg-orange-900/30 rounded-lg transition-colors">
                    <div class="bg-orange-500 text-white p-3 rounded-full mb-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">السجل</span>
                </a>
            </div>
        </div>

        <!-- التنبيهات -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">🔔 التنبيهات والتحذيرات</h2>
                <span id="unread-count" class="bg-red-500 text-white px-3 py-1 rounded-full text-sm">0</span>
            </div>

            <div id="alerts-container" class="space-y-3">
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">جاري تحميل التنبيهات...</p>
            </div>

            <div class="mt-4 flex gap-3">
                <button onclick="loadAlerts()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    تحديث التنبيهات
                </button>
                <button onclick="runChecks()" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                    فحص التنبيهات الآن
                </button>
                <button onclick="markAllAsRead()" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                    قراءة الكل
                </button>
            </div>
        </div>

        <!-- حالة المخزون -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">📦 حالة المخزون</h2>

            <div id="inventory-container" class="space-y-3">
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">جاري تحميل حالة المخزون...</p>
            </div>

            <div class="mt-4">
                <button onclick="loadInventory()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    تحديث المخزون
                </button>
                <button onclick="checkLowStock()"
                    class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700">
                    فحص النواقص
                </button>
            </div>
        </div>

        <!-- معلومات -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 dark:border-blue-400 p-4 mb-6">
            <div class="flex">
                <div class="shrink-0">
                    <svg class="h-5 w-5 text-blue-500 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="mr-3">
                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">معلومات مهمة</h3>
                    <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                        <ul class="list-disc list-inside space-y-1">
                            <li>يتم فحص التنبيهات تلقائياً كل ساعة</li>
                            <li>سيتم تنبيهك عندما يكون الدواء على وشك النفاد</li>
                            <li>يمكنك تحديث كمية الدواء من صفحة الأدوية</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        // Load alerts
        async function loadAlerts() {
            try {
                const response = await fetch('/api/alerts', {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${localStorage.getItem('token') || ''}`
                    }
                });

                const result = await response.json();

                if (result.success) {
                    displayAlerts(result.data);
                    document.getElementById('unread-count').textContent = result.unread_count;
                }
            } catch (error) {
                console.error('Error loading alerts:', error);
            }
        }

        // Display alerts
        function displayAlerts(alerts) {
            const container = document.getElementById('alerts-container');

            // Update active alerts count
            document.getElementById('active-alerts').textContent = alerts.length;

            if (alerts.length === 0) {
                container.innerHTML =
                    '<p class="text-gray-500 dark:text-gray-400 text-center py-4">لا توجد تنبيهات حالياً</p>';
                return;
            }

            container.innerHTML = alerts.map(alert => `
        <div class="border-r-4 ${getPriorityColor(alert.priority)} bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-900 dark:text-white">${alert.title}</h4>
                    <p class="text-gray-700 dark:text-gray-300 mt-1">${alert.message}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">${formatDate(alert.created_at)}</p>
                </div>
                <div class="flex gap-2 mr-4">
                    ${!alert.is_read ? `<button onclick="markAsRead(${alert.id})" class="text-blue-600 hover:text-blue-800 text-sm">قراءة</button>` : ''}
                    <button onclick="dismissAlert(${alert.id})" class="text-red-600 hover:text-red-800 text-sm">إخفاء</button>
                </div>
            </div>
        </div>
    `).join('');
        }

        // Load inventory
        async function loadInventory() {
            try {
                const response = await fetch('/api/inventory', {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${localStorage.getItem('token') || ''}`
                    }
                });

                const result = await response.json();

                if (result.success) {
                    displayInventory(result.data);
                }
            } catch (error) {
                console.error('Error loading inventory:', error);
            }
        }

        // Display inventory
        function displayInventory(inventory) {
            const container = document.getElementById('inventory-container');

            if (inventory.length === 0) {
                container.innerHTML =
                    '<p class="text-gray-500 dark:text-gray-400 text-center py-4">لا توجد أدوية مسجلة</p>';
                return;
            }

            container.innerHTML = inventory.map(item => `
        <div class="border rounded-lg p-4 ${item.is_low_stock ? 'bg-red-50 dark:bg-red-900/20 border-red-300 dark:border-red-700' : 'bg-gray-50 dark:bg-gray-700 border-gray-200 dark:border-gray-600'}">
            <div class="flex justify-between items-center">
                <div>
                    <h4 class="font-semibold text-gray-900 dark:text-white">${item.medicine_name}</h4>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">
                        الكمية: <span class="${item.is_low_stock ? 'text-red-600 font-bold' : 'text-green-600'}">${item.current_quantity || 0}</span> ${item.quantity_unit}
                    </p>
                    ${item.days_until_runs_out !== null ? `
                                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                    سينفد خلال: <strong>${item.days_until_runs_out} يوم</strong>
                                                </p>
                                            ` : ''}
                </div>
                <div class="text-left">
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium ${getStatusBadge(item.status)}">
                        ${item.status}
                    </span>
                </div>
            </div>
        </div>
    `).join('');
        }

        // Run checks
        async function runChecks() {
            try {
                const response = await fetch('/api/alerts/run-checks', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${localStorage.getItem('token') || ''}`
                    }
                });

                const result = await response.json();
                alert(result.message);
                loadAlerts();
            } catch (error) {
                console.error('Error running checks:', error);
            }
        }

        // Check low stock
        async function checkLowStock() {
            try {
                const response = await fetch('/api/inventory/check', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${localStorage.getItem('token') || ''}`
                    }
                });

                const result = await response.json();
                alert(result.message);
                loadInventory();
                loadAlerts();
            } catch (error) {
                console.error('Error checking low stock:', error);
            }
        }

        // Mark as read
        async function markAsRead(id) {
            try {
                const response = await fetch(`/api/alerts/${id}/read`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${localStorage.getItem('token') || ''}`
                    }
                });

                loadAlerts();
            } catch (error) {
                console.error('Error marking as read:', error);
            }
        }

        // Mark all as read
        async function markAllAsRead() {
            try {
                const response = await fetch('/api/alerts/read-all', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${localStorage.getItem('token') || ''}`
                    }
                });

                const result = await response.json();
                alert(result.message);
                loadAlerts();
            } catch (error) {
                console.error('Error marking all as read:', error);
            }
        }

        // Dismiss alert
        async function dismissAlert(id) {
            try {
                const response = await fetch(`/api/alerts/${id}/dismiss`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${localStorage.getItem('token') || ''}`
                    }
                });

                loadAlerts();
            } catch (error) {
                console.error('Error dismissing alert:', error);
            }
        }

        // Helper functions
        function getPriorityColor(priority) {
            switch (priority) {
                case 'high':
                    return 'border-red-500';
                case 'medium':
                    return 'border-yellow-500';
                case 'low':
                    return 'border-blue-500';
                default:
                    return 'border-gray-500';
            }
        }

        function getStatusBadge(status) {
            switch (status) {
                case 'نفد':
                    return 'bg-red-200 text-red-800';
                case 'منخفض':
                    return 'bg-orange-200 text-orange-800';
                case 'تحذير':
                    return 'bg-yellow-200 text-yellow-800';
                case 'جيد':
                    return 'bg-green-200 text-green-800';
                default:
                    return 'bg-gray-200 text-gray-800';
            }
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleString('ar-EG');
        }

        // Update statistics
        async function updateStats() {
            try {
                // Get medicines count
                const medicinesResponse = await fetch('/api/medicines', {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    credentials: 'same-origin'
                });
                if (medicinesResponse.ok) {
                    const medicinesData = await medicinesResponse.json();
                    document.getElementById('total-medicines').textContent = medicinesData.data?.length || 0;
                }

                // Get today's doses count
                const dosesResponse = await fetch('/api/doses/today', {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    credentials: 'same-origin'
                });
                if (dosesResponse.ok) {
                    const dosesData = await dosesResponse.json();
                    document.getElementById('today-doses').textContent = dosesData.data?.length || 0;
                }

                // Get low stock count
                const lowStockResponse = await fetch('/api/inventory/low-stock', {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    credentials: 'same-origin'
                });
                if (lowStockResponse.ok) {
                    const lowStockData = await lowStockResponse.json();
                    document.getElementById('low-stock-count').textContent = lowStockData.data?.length || 0;
                }
            } catch (error) {
                console.error('Error updating stats:', error);
            }
        }

        // Load data on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateStats();
            loadAlerts();
            loadInventory();

            // Refresh every 5 minutes
            setInterval(() => {
                updateStats();
                loadAlerts();
                loadInventory();
            }, 5 * 60 * 1000);
        });
    </script>
@endsection
