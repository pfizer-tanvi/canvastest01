<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardControllerTest extends FeatureTestCase
{
    use RefreshDatabase;

    public function testGuestIsRedirectedToLogin(): void
    {
        $this
            ->get('/')
            ->assertRedirect('/login');
    }

    public function testUserCanViewDashboard(): void
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->get('/')
            ->assertOk()
            ->assertViewIs('dashboard');
    }
}
