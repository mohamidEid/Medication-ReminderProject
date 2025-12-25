<?php

namespace Tests\Feature\Security;

use Tests\TestCase;
use App\Models\User;
use App\Models\Medicine;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cannot_access_dashboard()
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    /** @test */
    public function guest_cannot_access_medicines()
    {
        $response = $this->get('/medicines');

        $response->assertRedirect('/login');
    }

    /** @test */
    public function user_cannot_view_others_medicines()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $medicine = Medicine::factory()->create(['user_id' => $user1->id]);

        $response = $this->actingAs($user2)->get("/medicines/{$medicine->id}");

        $response->assertStatus(403);
    }

    /** @test */
    public function user_cannot_delete_others_medicines()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $medicine = Medicine::factory()->create(['user_id' => $user1->id]);

        $response = $this->actingAs($user2)->delete("/medicines/{$medicine->id}");

        $response->assertStatus(403);
    }

    /** @test */
    public function csrf_protection_is_enabled()
    {
        $user = User::factory()->create();

        // Attempt POST without CSRF token
        $response = $this->post('/logout');

        $response->assertStatus(419); // CSRF token mismatch
    }

    /** @test */
    public function sql_injection_is_prevented()
    {
        $user = User::factory()->create();

        // Attempt SQL injection
        $response = $this->actingAs($user)->get('/medicines?search=' . urlencode("'; DROP TABLE medicines; --"));

        // Should not crash and return normal status
        $this->assertTrue(in_array($response->status(), [200, 404]));

        // Table should still exist
        $this->assertTrue(\Schema::hasTable('medicines'));
    }

    /** @test */
    public function xss_attack_is_prevented()
    {
        $user = User::factory()->create();

        $medicine = Medicine::factory()->create([
            'user_id' => $user->id,
            'name' => '<script>alert("XSS")</script>',
        ]);

        $response = $this->actingAs($user)->get('/medicines');

        // Script tags should be escaped
        $response->assertDontSee('<script>', false);
        $response->assertSee('&lt;script&gt;', false);
    }
}
