<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\MedicineService;
use App\Models\Medicine;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MedicineServiceTest extends TestCase
{
    use RefreshDatabase;

    protected MedicineService $service;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new MedicineService();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function it_can_create_medicine_with_valid_data()
    {
        $data = [
            'name' => 'Test Medicine',
            'dosage' => '500mg',
            'frequency' => 'daily',
            'start_date' => now()->format('Y-m-d'),
            'times' => ['08:00', '14:00', '20:00'],
            'instructions' => 'Take with food',
        ];

        $medicine = $this->service->createMedicine($this->user->id, $data);

        $this->assertInstanceOf(Medicine::class, $medicine);
        $this->assertEquals('Test Medicine', $medicine->name);
        $this->assertEquals($this->user->id, $medicine->user_id);
    }

    /** @test */
    public function it_generates_doses_when_creating_medicine()
    {
        $data = [
            'name' => 'Test Medicine',
            'dosage' => '500mg',
            'frequency' => 'daily',
            'start_date' => now()->format('Y-m-d'),
            'times' => ['08:00'],
        ];

        $medicine = $this->service->createMedicine($this->user->id, $data);

        // Should create doses for 30 days
        $this->assertTrue($medicine->doses()->count() > 0);
    }

    /** @test */
    public function it_can_delete_medicine()
    {
        $medicine = Medicine::factory()->create(['user_id' => $this->user->id]);

        $result = $this->service->deleteMedicine($medicine);

        $this->assertTrue($result);
        $this->assertNull(Medicine::find($medicine->id));
    }

    /** @test */
    public function it_can_get_user_medicines()
    {
        Medicine::factory()->count(3)->create(['user_id' => $this->user->id]);

        $medicines = $this->service->getUserMedicines($this->user->id);

        $this->assertCount(3, $medicines);
    }
}
