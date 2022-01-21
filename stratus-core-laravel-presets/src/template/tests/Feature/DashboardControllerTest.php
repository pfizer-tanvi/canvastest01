<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers App\Http\Controllers\DashboardController::__invoke
     */
    public function testAuth()
    {
        $user = factory(\App\User::class)->create();
        $this->be($user);
        $this->get('/dashboard')->assertStatus(200);
    }
}
