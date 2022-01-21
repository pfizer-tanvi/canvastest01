<?php

namespace Tests\Feature;

use App\Http\Middleware\CanAdmin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class CanAdminTest extends TestCase
{
    use RefreshDatabase;

    public function testCanAdmin()
    {
        $user = \App\Models\User::factory()->create(['is_super_admin' => true]);
        $this->be($user);
        $middleware = new CanAdmin();

        $request = new Request();
        $results = $middleware->handle($request, function () {
            return true;
        });
        $this->assertTrue($results);
    }


    public function testCanNotAdmin()
    {
        \App\Models\User::factory()->create();
        $user = \App\Models\User::factory()->create();
        $this->be($user);
        $middleware = new CanAdmin();
        $request = new Request();
        $results = $middleware->handle($request, function () {
            return true;
        });
        $this->assertNotTrue($results);
    }
}
