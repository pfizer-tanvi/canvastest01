<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends FeatureTestCase
{
    use RefreshDatabase;

    public function testGuestCanViewLoginPage(): void
    {
        $this
            ->get('/login')
            ->assertOk()
            ->assertViewIs('auth.login');
    }

    public function testUserIsRedirectedToDashboard(): void
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->get('/login')
            ->assertRedirect(RouteServiceProvider::HOME);
    }
}
