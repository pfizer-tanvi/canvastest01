<?php

namespace Tests\Feature;

use Exception;
use Illuminate\Support\Facades\View;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testAuth(): void
    {
        $user = factory(\App\User::class)->create();
        $this->be($user);
        $this->get('/dashboard')->assertStatus(200);
    }

    public function testItFailsIfNoDashboardViewIsRegistered(): void
    {
        View::partialMock()->shouldReceive('make')->andThrow(Exception::class);
        $user = factory(\App\User::class)->create();
        $this->be($user);
        $var = $this->get('/dashboard')->assertStatus(302)->assertSessionHasErrors();
    }
}
