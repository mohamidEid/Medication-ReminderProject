<?php

namespace App\Services;

use App\Models\Medicine;
use App\Models\Dose;
use Carbon\Carbon;

/**
 * Medicine Service
 *
 * Handles all business logic related to medicines and dose scheduling
 */
class MedicineService
{
    /**
     * Create a new medicine and generate doses
     *
     * @param int $userId
     * @param array $data
     * @return Medicine
     */
    public function createMedicine(int $userId, array $data): Medicine
    {
        // Create medicine
        $medicine = Medicine::create([
            'user_id' => $userId,
            'name' => $data['name'],
            'dosage' => $data['dosage'],
            'frequency' => $data['frequency'],
            'start_date' => $data['start_date'],
            'times' => json_encode($data['times']),
            'instructions' => $data['instructions'] ?? null,
        ]);

        // Generate doses for next 30 days
        $this->generateDoses($medicine);

        return $medicine;
    }

    /**
     * Delete medicine and all related doses
     *
     * @param Medicine $medicine
     * @return bool
     */
    public function deleteMedicine(Medicine $medicine): bool
    {
        return $medicine->delete();
    }

    /**
     * Generate doses for a medicine
     *
     * @param Medicine $medicine
     * @param int $days Number of days to generate doses for
     * @return int Number of doses created
     */
    public function generateDoses(Medicine $medicine, int $days = 30): int
    {
        $startDate = Carbon::parse($medicine->start_date);
        $endDate = $startDate->copy()->addDays($days);
        $times = json_decode($medicine->times, true);

        $dosesCreated = 0;

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            foreach ($times as $time) {
                $scheduledTime = Carbon::parse($date->format('Y-m-d') . ' ' . $time);

                // Skip if time is in the past
                if ($scheduledTime->isPast()) {
                    continue;
                }

                Dose::create([
                    'user_id' => $medicine->user_id,
                    'medicine_id' => $medicine->id,
                    'scheduled_time' => $scheduledTime,
                    'status' => 'pending'
                ]);

                $dosesCreated++;
            }
        }

        return $dosesCreated;
    }

    /**
     * Get all medicines for a user
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserMedicines(int $userId)
    {
        return Medicine::where('user_id', $userId)
            ->latest()
            ->get();
    }

    /**
     * Get medicine with doses
     *
     * @param int $medicineId
     * @return Medicine
     */
    public function getMedicineWithDoses(int $medicineId): Medicine
    {
        return Medicine::with(['doses' => function ($query) {
            $query->latest('scheduled_time')->limit(10);
        }])->findOrFail($medicineId);
    }

    /**
     * Check if user owns medicine
     *
     * @param int $userId
     * @param int $medicineId
     * @return bool
     */
    public function userOwnsMedicine(int $userId, int $medicineId): bool
    {
        return Medicine::where('id', $medicineId)
            ->where('user_id', $userId)
            ->exists();
    }
}
