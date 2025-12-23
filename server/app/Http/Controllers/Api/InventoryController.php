<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Services\InventoryService;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    protected InventoryService $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    /**
     * Get inventory status for all medicines
     */
    public function index(Request $request)
    {
        $status = $this->inventoryService->getInventoryStatus($request->user());

        return response()->json([
            'success' => true,
            'data' => $status,
        ]);
    }

    /**
     * Get inventory status for specific medicine
     */
    public function show($id)
    {
        $medicine = Medicine::where('user_id', auth()->id())
            ->findOrFail($id);

        $daysUntilRunsOut = $this->inventoryService->daysUntilRunsOut($medicine);

        return response()->json([
            'success' => true,
            'data' => [
                'medicine_id' => $medicine->id,
                'medicine_name' => $medicine->name,
                'current_quantity' => $medicine->current_quantity,
                'quantity_unit' => $medicine->quantity_unit,
                'min_quantity_alert' => $medicine->min_quantity_alert,
                'is_low_stock' => $this->inventoryService->isLowStock($medicine),
                'days_until_runs_out' => $daysUntilRunsOut,
            ],
        ]);
    }

    /**
     * Record medication refill
     */
    public function refill(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $medicine = Medicine::where('user_id', auth()->id())
            ->findOrFail($id);

        $refill = $this->inventoryService->recordRefill(
            $medicine,
            $request->quantity,
            $request->notes
        );

        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل التعبئة بنجاح',
            'data' => $refill,
        ]);
    }

    /**
     * Update medicine quantity
     */
    public function updateQuantity(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:0',
        ]);

        $medicine = Medicine::where('user_id', auth()->id())
            ->findOrFail($id);

        $this->inventoryService->updateQuantity($medicine, $request->quantity);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الكمية بنجاح',
        ]);
    }

    /**
     * Check all medicines for low stock
     */
    public function checkLowStock(Request $request)
    {
        $this->inventoryService->checkAllMedicines($request->user());

        return response()->json([
            'success' => true,
            'message' => 'تم فحص المخزون',
        ]);
    }

    /**
     * Get low stock medicines
     */
    public function lowStock(Request $request)
    {
        $medicines = Medicine::where('user_id', $request->user()->id)
            ->whereNotNull('current_quantity')
            ->whereNotNull('min_quantity_alert')
            ->whereRaw('current_quantity <= min_quantity_alert')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $medicines,
        ]);
    }
}
