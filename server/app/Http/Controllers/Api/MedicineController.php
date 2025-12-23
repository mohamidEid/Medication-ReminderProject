<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\Dose;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Carbon\Carbon;

class MedicineController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $medicines = $request->user()
            ->medicines()
            ->with('doses')
            ->latest()
            ->get();

        return response()->json($medicines);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'dosage' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:50',
            'frequency' => 'required|string',
            'times' => 'required|array',
            'times.*' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'stock' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $medicine = $request->user()->medicines()->create($request->all());

        // Generate doses for the next 30 days
        $this->generateDoses($medicine);

        return response()->json($medicine->load('doses'), 201);
    }

    public function show(Request $request, Medicine $medicine)
    {
        $this->authorize('view', $medicine);

        return response()->json($medicine->load('doses'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $this->authorize('update', $medicine);

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'dosage' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:50',
            'frequency' => 'sometimes|required|string',
            'times' => 'sometimes|required|array',
            'times.*' => 'required|string',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'nullable|date|after:start_date',
            'stock' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $medicine->update($request->all());

        return response()->json($medicine->load('doses'));
    }

    public function destroy(Request $request, Medicine $medicine)
    {
        $this->authorize('delete', $medicine);

        $medicine->delete();

        return response()->json(['message' => 'Medicine deleted successfully']);
    }

    private function generateDoses(Medicine $medicine)
    {
        $startDate = Carbon::parse($medicine->start_date);
        $endDate = $medicine->end_date ? Carbon::parse($medicine->end_date) : $startDate->copy()->addDays(30);

        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            foreach ($medicine->times as $time) {
                $scheduledTime = $currentDate->copy()->setTimeFromTimeString($time);

                Dose::create([
                    'user_id' => $medicine->user_id,
                    'medicine_id' => $medicine->id,
                    'scheduled_time' => $scheduledTime,
                    'status' => 'pending',
                ]);
            }

            $currentDate->addDay();
        }
    }
}
