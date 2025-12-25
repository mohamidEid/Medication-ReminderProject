<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Http\Requests\StoreMedicineRequest;
use App\Services\MedicineService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

/**
 * Medicine Controller
 *
 * Handles medicine management for authenticated users
 * Following Clean Code principles with Service Layer pattern
 */
class MedicineController extends Controller
{
    use \Illuminate\Foundation\Auth\Access\AuthorizesRequests;

    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected MedicineService $medicineService
    ) {
        // Middleware is applied in routes/web.php
    }


    /**
     * Display a listing of user's medicines
     *
     * @return View
     */
    public function index(): View
    {
        $medicines = $this->medicineService->getUserMedicines(Auth::id());

        return view('medicines.index', compact('medicines'));
    }

    /**
     * Show the form for creating a new medicine
     *
     * @return View
     */
    public function create(): View
    {
        return view('medicines.create');
    }

    /**
     * Store a newly created medicine
     *
     * @param StoreMedicineRequest $request
     * @return RedirectResponse
     */
    public function store(StoreMedicineRequest $request): RedirectResponse
    {
        $medicine = $this->medicineService->createMedicine(
            Auth::id(),
            $request->validated()
        );

        return redirect()
            ->route('medicines.index')
            ->with('success', 'تم إضافة الدواء وسجل الجرعات بنجاح!');
    }

    /**
     * Display the specified medicine
     *
     * @param Medicine $medicine
     * @return View
     */
    public function show(Medicine $medicine): View
    {
        $this->authorize('view', $medicine);

        $medicine->load(['doses' => function ($query) {
            $query->latest('scheduled_time')->limit(20);
        }]);

        return view('medicines.show', compact('medicine'));
    }

    /**
     * Show the form for editing the specified medicine
     *
     * @param Medicine $medicine
     * @return View
     */
    public function edit(Medicine $medicine): View
    {
        $this->authorize('update', $medicine);

        return view('medicines.edit', compact('medicine'));
    }

    /**
     * Update the specified medicine
     *
     * @param StoreMedicineRequest $request
     * @param Medicine $medicine
     * @return RedirectResponse
     */
    public function update(StoreMedicineRequest $request, Medicine $medicine): RedirectResponse
    {
        $this->authorize('update', $medicine);

        $medicine->update($request->validated());

        return redirect()
            ->route('medicines.index')
            ->with('success', 'تم تحديث الدواء بنجاح!');
    }

    /**
     * Remove the specified medicine
     *
     * @param Medicine $medicine
     * @return RedirectResponse
     */
    public function destroy(Medicine $medicine): RedirectResponse
    {
        $this->authorize('delete', $medicine);

        $this->medicineService->deleteMedicine($medicine);

        return redirect()
            ->route('medicines.index')
            ->with('success', 'تم حذف الدواء بنجاح.');
    }
}
