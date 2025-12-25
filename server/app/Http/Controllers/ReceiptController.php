<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionReceipt;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptController extends Controller
{
    /**
     * Download receipt as PDF
     */
    public function downloadPdf($id)
    {
        $receipt = SubscriptionReceipt::with(['user'])->findOrFail($id);

        // Check authorization
        if (auth()->id() !== $receipt->user_id && !auth()->user()->hasRole(['admin', 'super_admin'])) {
            abort(403, 'غير مصرح لك بتحميل هذا الإيصال');
        }

        // Set default amount if not set
        if (!$receipt->amount) {
            $receipt->amount = 100;
        }

        $pdf = Pdf::loadView('pdf.receipt', compact('receipt'));

        $filename = 'receipt-' . str_pad($receipt->id, 6, '0', STR_PAD_LEFT) . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * View receipt as PDF in browser
     */
    public function viewPdf($id)
    {
        $receipt = SubscriptionReceipt::with(['user'])->findOrFail($id);

        // Check authorization
        if (auth()->id() !== $receipt->user_id && !auth()->user()->hasRole(['admin', 'super_admin'])) {
            abort(403, 'غير مصرح لك بعرض هذا الإيصال');
        }

        // Set default amount if not set
        if (!$receipt->amount) {
            $receipt->amount = 100;
        }

        $pdf = Pdf::loadView('pdf.receipt', compact('receipt'));

        return $pdf->stream('receipt-' . $receipt->id . '.pdf');
    }

    /**
     * View receipt details page
     */
    public function show($id)
    {
        $receipt = SubscriptionReceipt::with(['user'])->findOrFail($id);

        //Check authorization
        if (auth()->id() !== $receipt->user_id && !auth()->user()->hasRole(['admin', 'super_admin'])) {
            abort(403);
        }

        return view('receipts.show', compact('receipt'));
    }

    /**
     * Print receipt page
     */
    public function print($id)
    {
        $receipt = SubscriptionReceipt::with(['user'])->findOrFail($id);

        // Check authorization
        if (auth()->id() !== $receipt->user_id && !auth()->user()->hasRole(['admin', 'super_admin'])) {
            abort(403);
        }

        return view('receipts.print', compact('receipt'));
    }
}
