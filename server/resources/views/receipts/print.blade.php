@extends('layouts.app')

@section('content')
    <div class="print-container" dir="rtl">
        <div class="no-print text-center mb-4">
            <button onclick="window.print()"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-bold text-lg shadow-lg">
                🖨️ طباعة الإيصال
            </button>
            <a href="{{ route('subscription.create') }}"
                class="inline-block mr-3 bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-bold text-lg shadow-lg">
                العودة
            </a>
        </div>

        <div class="receipt-content">
            <!-- Header -->
            <div class="header">
                <h1>🏥 MediRemind</h1>
                <p>نظام إدارة الأدوية الذكي</p>
            </div>

            <!-- Content -->
            <div class="content">
                <h2 style="text-align: center; color: #667eea; margin-bottom: 20px;">إيصال اشتراك</h2>

                <table class="info-table">
                    <tr>
                        <td class="label">رقم الإيصال:</td>
                        <td class="value">#{{ str_pad($receipt->id, 6, '0', STR_PAD_LEFT) }}</td>
                    </tr>
                    <tr>
                        <td class="label">اسم العميل:</td>
                        <td class="value">{{ $receipt->user->name }}</td>
                    </tr>
                    <tr>
                        <td class="label">البريد الإلكتروني:</td>
                        <td class="value">{{ $receipt->user->email }}</td>
                    </tr>
                    <tr>
                        <td class="label">رقم الهاتف:</td>
                        <td class="value">{{ $receipt->phone }}</td>
                    </tr>
                    <tr>
                        <td class="label">الباقة:</td>
                        <td class="value">باقة MediRemind الشهرية</td>
                    </tr>
                </table>

                <!-- Amount Box -->
                <div class="amount-box">
                    <h2>{{ $receipt->amount ?? 100 }} جنيه</h2>
                    <p>المبلغ المدفوع</p>
                </div>

                <table class="info-table">
                    <tr>
                        <td class="label">تاريخ الاشتراك:</td>
                        <td class="value">{{ $receipt->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="label">المدة:</td>
                        <td class="value">شهر واحد</td>
                    </tr>
                    <tr>
                        <td class="label">الحالة:</td>
                        <td class="value">
                            @if ($receipt->status === 'approved')
                                <span class="badge badge-success">✓ معتمد</span>
                            @elseif($receipt->status === 'pending')
                                <span class="badge badge-warning">⏳ قيد المراجعة</span>
                            @else
                                <span class="badge badge-danger">✗ مرفوض</span>
                            @endif
                        </td>
                    </tr>
                </table>

                @if ($receipt->notes)
                    <div class="notes-box">
                        <strong>ملاحظاتك:</strong>
                        <p>{{ $receipt->notes }}</p>
                    </div>
                @endif

                @if ($receipt->admin_notes)
                    <div class="admin-notes-box">
                        <strong>ملاحظات الإدارة:</strong>
                        <p>{{ $receipt->admin_notes }}</p>
                    </div>
                @endif

                @if ($receipt->receipt_path)
                    <div class="receipt-image">
                        <h3>صورة إيصال الدفع:</h3>
                        <img src="{{ Storage::url($receipt->receipt_path) }}" alt="إيصال الدفع">
                    </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="footer">
                <p><strong>MediRemind</strong> - نظام إدارة الأدوية الذكي</p>
                <p>📧 support@mediremind.com | 📞 890 507 234</p>
                <p>تاريخ الطباعة: {{ now()->format('Y-m-d H:i:s') }}</p>
            </div>
        </div>
    </div>

    <style>
        body {
            font-family: 'Cairo', 'Arial', sans-serif;
        }

        .print-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .receipt-content {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 32px;
            margin: 0 0 10px 0;
        }

        .header p {
            font-size: 16px;
            margin: 0;
            opacity: 0.9;
        }

        .content {
            padding: 30px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .info-table tr {
            border-bottom: 1px solid #eee;
        }

        .info-table td {
            padding: 15px;
        }

        .info-table .label {
            font-weight: 600;
            color: #666;
            width: 40%;
        }

        .info-table .value {
            color: #333;
            font-weight: 700;
        }

        .amount-box {
            background: #f3f4f6;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }

        .amount-box h2 {
            color: #667eea;
            font-size: 36px;
            margin: 0 0 5px 0;
        }

        .amount-box p {
            color: #666;
            font-size: 14px;
            margin: 0;
        }

        .badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .badge-success {
            background: #D1FAE5;
            color: #065F46;
        }

        .badge-warning {
            background: #FEF3C7;
            color: #92400E;
        }

        .badge-danger {
            background: #FEE2E2;
            color: #991B1B;
        }

        .notes-box,
        .admin-notes-box {
            margin: 20px 0;
            padding: 15px;
            border-radius: 8px;
        }

        .notes-box {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
        }

        .admin-notes-box {
            background: #fef3c7;
            border: 1px solid #fde68a;
        }

        .notes-box strong,
        .admin-notes-box strong {
            color: #666;
            display: block;
            margin-bottom: 5px;
        }

        .notes-box p,
        .admin-notes-box p {
            color: #333;
            margin: 0;
        }

        .receipt-image {
            margin: 20px 0;
            text-align: center;
        }

        .receipt-image h3 {
            color: #666;
            margin-bottom: 10px;
        }

        .receipt-image img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            border: 2px solid #e5e7eb;
        }

        .footer {
            background: #f9fafb;
            padding: 20px;
            text-align: center;
            border-top: 2px solid #e5e7eb;
        }

        .footer p {
            color: #6b7280;
            font-size: 14px;
            margin: 5px 0;
        }

        /* Print Styles */
        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .no-print {
                display: none !important;
            }

            .print-container {
                max-width: 100%;
                padding: 0;
            }

            .receipt-content {
                box-shadow: none;
                border-radius: 0;
            }

            .header {
                background: #667eea !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .amount-box {
                background: #f3f4f6 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .badge {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .footer {
                background: #f9fafb !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            /* Page break handling */
            .receipt-content {
                page-break-inside: avoid;
            }
        }
    </style>
@endsection
