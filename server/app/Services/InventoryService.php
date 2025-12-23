<?php

namespace App\Services;

use App\Models\Medicine;
use App\Models\MedicationRefill;
use App\Models\User;
use App\Models\Dose;
use Carbon\Carbon;

/**
 * InventoryService - manages medication inventory and low stock alerts
 */
class InventoryService
{
    protected AlertService $alertService;

    public function __construct(AlertService $alertService)
    {
        $this->alertService = $alertService;
    }

    /**
     * Calculate current quantity based on doses taken
     */
    public function calculateCurrentQuantity(Medicine $medicine): float
    {
        // Get initial quantity from last refill or medicine
        $lastRefill = MedicationRefill::where('medicine_id', $medicine->id)
            ->latest('refill_date')
            ->first();

        $startDate = $lastRefill ? $lastRefill->refill_date : $medicine->created_at->toDateString();
        $initialQuantity = $lastRefill ? $lastRefill->quantity : ($medicine->current_quantity ?? 0);

        // Calculate doses taken since then
        $dosesTaken = Dose::where('medicine_id', $medicine->id)
            ->where('status', 'taken')
            ->whereDate('taken_at', '>=', $startDate)
            ->count();

        // Assume 1 unit per dose (this should be configurable)
        $currentQuantity = $initialQuantity - $dosesTaken;

        return max(0, $currentQuantity);
    }

    /**
     * Update medicine quantity
     */
    public function updateQuantity(Medicine $medicine, float $quantity): void
    {
        $medicine->update([
            'current_quantity' => $quantity,
            'low_stock_alert_sent' => false, // Reset alert flag
        ]);
    }

    /**
     * Record a refill
     */
    public function recordRefill(Medicine $medicine, float $quantity, ?string $notes = null): MedicationRefill
    {
        $refill = MedicationRefill::create([
            'user_id' => $medicine->user_id,
            'medicine_id' => $medicine->id,
            'quantity' => $quantity,
            'quantity_unit' => $medicine->quantity_unit ?? 'pills',
            'notes' => $notes,
            'refill_date' => now()->toDateString(),
        ]);

        // Update current quantity
        $newQuantity = ($medicine->current_quantity ?? 0) + $quantity;
        $this->updateQuantity($medicine, $newQuantity);

        return $refill;
    }

    /**
     * Check if medicine is low on stock
     */
    public function isLowStock(Medicine $medicine): bool
    {
        if (!$medicine->min_quantity_alert || !$medicine->current_quantity) {
            return false;
        }

        return $medicine->current_quantity <= $medicine->min_quantity_alert;
    }

    /**
     * Calculate days until medicine runs out
     */
    public function daysUntilRunsOut(Medicine $medicine): ?int
    {
        $currentQuantity = $medicine->current_quantity ?? $this->calculateCurrentQuantity($medicine);

        if ($currentQuantity <= 0) {
            return 0;
        }

        // Calculate daily consumption based on scheduled doses
        $dailyDoses = Dose::where('medicine_id', $medicine->id)
            ->where('scheduled_time', '>=', now()->subDays(7))
            ->where('scheduled_time', '<=', now())
            ->count();

        $averageDailyConsumption = $dailyDoses / 7;

        if ($averageDailyConsumption == 0) {
            return null; // Can't calculate
        }

        return (int) ceil($currentQuantity / $averageDailyConsumption);
    }

    /**
     * Send low stock alert
     */
    public function sendLowStockAlert(Medicine $medicine): void
    {
        if ($medicine->low_stock_alert_sent) {
            return; // Already sent
        }

        $daysLeft = $this->daysUntilRunsOut($medicine);
        $user = $medicine->user;

        $message = $daysLeft !== null
            ? "دواء {$medicine->name} سينفد خلال {$daysLeft} يوم. الكمية المتبقية: {$medicine->current_quantity} {$medicine->quantity_unit}"
            : "دواء {$medicine->name} أوشك على النفاد. الكمية المتبقية: {$medicine->current_quantity} {$medicine->quantity_unit}";

        $this->alertService->createAlert(
            $user,
            'low_stock',
            'تنبيه نفاد الدواء',
            $message,
            [
                'medicine_id' => $medicine->id,
                'current_quantity' => $medicine->current_quantity,
                'min_quantity' => $medicine->min_quantity_alert,
                'days_until_runs_out' => $daysLeft,
            ],
            'high'
        );

        $medicine->update(['low_stock_alert_sent' => true]);
    }

    /**
     * Check all medicines for low stock
     */
    public function checkAllMedicines(User $user): void
    {
        $medicines = Medicine::where('user_id', $user->id)
            ->whereNotNull('current_quantity')
            ->whereNotNull('min_quantity_alert')
            ->get();

        foreach ($medicines as $medicine) {
            // Update current quantity based on consumption
            $currentQty = $this->calculateCurrentQuantity($medicine);
            $medicine->update(['current_quantity' => $currentQty]);

            // Check if low stock
            if ($this->isLowStock($medicine)) {
                $this->sendLowStockAlert($medicine);
            }
        }
    }

    /**
     * Get inventory status for all medicines
     */
    public function getInventoryStatus(User $user): array
    {
        $medicines = Medicine::where('user_id', $user->id)
            ->whereNotNull('current_quantity')
            ->get();

        return $medicines->map(function ($medicine) {
            return [
                'medicine_id' => $medicine->id,
                'medicine_name' => $medicine->name,
                'current_quantity' => $medicine->current_quantity,
                'quantity_unit' => $medicine->quantity_unit,
                'min_quantity_alert' => $medicine->min_quantity_alert,
                'is_low_stock' => $this->isLowStock($medicine),
                'days_until_runs_out' => $this->daysUntilRunsOut($medicine),
                'status' => $this->getStatus($medicine),
            ];
        })->toArray();
    }

    /**
     * Get status label for medicine
     */
    protected function getStatus(Medicine $medicine): string
    {
        $daysLeft = $this->daysUntilRunsOut($medicine);

        if ($medicine->current_quantity <= 0) {
            return 'نفد';
        }

        if ($this->isLowStock($medicine)) {
            return 'منخفض';
        }

        if ($daysLeft !== null && $daysLeft <= 7) {
            return 'تحذير';
        }

        return 'جيد';
    }
}
