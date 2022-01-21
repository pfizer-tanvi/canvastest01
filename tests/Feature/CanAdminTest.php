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
        $user = factory(\App\User::class)->create(['is_super_admin' => true]);
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
        factory(\App\User::class)->create();
        $user = factory(\App\User::class)->create();
        $this->be($user);
        $middleware = new CanAdmin();
        $request = new Request();
        $results = $middleware->handle($request, function () {
            return true;
        });
        $this->assertNotTrue($results);
    }
}
