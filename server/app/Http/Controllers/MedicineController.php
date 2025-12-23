<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Dose;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MedicineController extends Controller
{
    public function index()
    {
        $medicines = Auth::user()->medicines()->latest()->get();
        return view('medicines.index', compact('medicines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'dosage' => 'required|string|max:255',
            'frequency' => 'required|in:daily,twice_daily,three_times_daily',
            'start_date' => 'required|date',
            'times' => 'required|array',
            'times.*' => 'required|date_format:H:i',
        ]);

        $medicine = Auth::user()->medicines()->create([
            'name' => $request->name,
            'dosage' => $request->dosage,
            'frequency' => $request->frequency,
            'start_date' => $request->start_date,
            'times' => json_encode($request->times),
            'instructions' => $request->instructions,
        ]);

        // Generate Doses for the next 30 days
        $this->generateDoses($medicine);

        return redirect()->route('web.medicines.index')->with('success', 'تم إضافة الدواء وسجل الجرعات بنجاح!');
    }

    public function destroy(Medicine $medicine)
    {
        if ($medicine->user_id !== Auth::id()) {
            abort(403);
        }

        $medicine->delete();
        return redirect()->route('web.medicines.index')->with('success', 'تم حذف الدواء بنجاح.');
    }

    private function generateDoses(Medicine $medicine)
    {
        $startDate = Carbon::parse($medicine->start_date);
        $endDate = $startDate->copy()->addDays(30); // Generate for 30 days
        $times = json_decode($medicine->times);

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            foreach ($times as $time) {
                $scheduledTime = Carbon::parse($date->format('Y-m-d') . ' ' . $time);

                // Skip if time is in the past
                if ($scheduledTime->isPast()) continue;

                Dose::create([
                    'user_id' => $medicine->user_id,
                    'medicine_id' => $medicine->id,
                    'scheduled_time' => $scheduledTime,
                    'status' => 'pending'
                ]);
            }
        }
    }
}
