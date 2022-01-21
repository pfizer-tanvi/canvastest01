<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageUsersControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStatus()
    {
        $this->withoutExceptionHandling();
        $user = factory(\App\User::class)->create(['is_super_admin' => 1]);
        $this->be($user);
        $this->get("/admin/users")->assertStatus(200);
    }
}
