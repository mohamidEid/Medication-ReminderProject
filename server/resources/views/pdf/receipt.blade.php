<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إيصال اشتراك - MediRemind</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', 'DejaVu Sans', sans-serif;
            direction: rtl;
            background: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
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
            margin-bottom: 10px;
        }

        .header p {
            font-size: 16px;
            opacity: 0.9;
        }

        .content {
            padding: 30px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #666;
        }

        .info-value {
            color: #333;
            font-weight: 700;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .status-pending {
            background: #FEF3C7;
            color: #92400E;
        }

        .status-active {
            background: #D1FAE5;
            color: #065F46;
        }

        .status-expired {
            background: #FEE2E2;
            color: #991B1B;
        }

        .footer {
            background: #f9fafb;
            padding: 20px;
            text-align: center;
            border-top: 2px solid #e5e7eb;
            margin-top: 30px;
        }

        .footer p {
            color: #6b7280;
            font-size: 14px;
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
            margin-bottom: 5px;
        }

        .amount-box p {
            color: #666;
            font-size: 14px;
        }

        .receipt-image {
            margin: 20px 0;
            text-align: center;
        }

        .receipt-image img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            border: 2px solid #e5e7eb;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🏥 MediRemind</h1>
            <p>نظام إدارة الأدوية الذكي</p>
        </div>

        <div class="content">
            <h2 style="text-align: center; color: #667eea; margin-bottom: 20px;">إيصال اشتراك</h2>

            <div class="info-row">
                <span class="info-label">رقم الإيصال:</span>
                <span class="info-value">#{{ str_pad($receipt->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">اسم العميل:</span>
                <span class="info-value">{{ $receipt->user->name }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">البريد الإلكتروني:</span>
                <span class="info-value">{{ $receipt->user->email }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">رقم الهاتف:</span>
                <span class="info-value">{{ $receipt->user->phone ?? 'غير محدد' }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">الباقة:</span>
                <span class="info-value">باقة MediRemind الشهرية</span>
            </div>

            <div class="amount-box">
                <h2>{{ number_format($receipt->amount, 2) }} جنيه</h2>
                <p>المبلغ المدفوع</p>
            </div>

            <div class="info-row">
                <span class="info-label">تاريخ الاشتراك:</span>
                <span class="info-value">{{ $receipt->created_at->format('Y-m-d H:i') }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">المدة:</span>
                <span class="info-value">شهر واحد</span>
            </div>

            <div class="info-row">
                <span class="info-label">الحالة:</span>
                <span class="info-value">
                    @if ($receipt->status === 'approved')
                        <span class="status-badge status-active">✓ معتمد</span>
                    @elseif($receipt->status === 'pending')
                        <span class="status-badge status-pending">⏳ قيد المراجعة</span>
                    @else
                        <span class="status-badge status-expired">✗ مرفوض</span>
                    @endif
                </span>
            </div>

            @if ($receipt->receipt_image)
                <div class="receipt-image">
                    <h3 style="color: #666; margin-bottom: 10px;">صورة إيصال الدفع:</h3>
                    <img src="{{ public_path('storage/' . $receipt->receipt_image) }}" alt="إيصال الدفع">
                </div>
            @endif

            @if ($receipt->notes)
                <div style="margin-top: 20px; padding: 15px; background: #f9fafb; border-radius: 8px;">
                    <strong style="color: #666;">ملاحظات:</strong>
                    <p style="margin-top: 5px; color: #333;">{{ $receipt->notes }}</p>
                </div>
            @endif
        </div>

        <div class="footer">
            <p><strong>MediRemind</strong> - نظام إدارة الأدوية الذكي</p>
            <p style="margin-top: 5px;">📧 support@mediremind.com | 📞 890 507 234</p>
            <p style="margin-top: 10px; font-size: 12px;">تم الطباعة في: {{ now()->format('Y-m-d H:i:s') }}</p>
        </div>
    </div>
</body>

</html>
