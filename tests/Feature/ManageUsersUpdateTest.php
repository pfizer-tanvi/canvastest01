<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ManageUsersUpdateTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    public function testCanUpdate()
    {
        $user = factory(\App\User::class)->create(
            ['is_super_admin' => true]
        );
        $this->be($user);
        $userToUpdate = factory(\App\User::class)->create();

        $this->put(route('manageUsers.update', [
            'user_id' => $userToUpdate->id,
            'email' => "bar@pfizer.com",
            'is_super_admin' => 0,
        ]))->assertStatus(200);

        $this->assertEquals('bar@pfizer.com', $userToUpdate->refresh()->email);
    }

    public function testCanSetAdmin()
    {
        $user = factory(\App\User::class)->create(
            ['is_super_admin' => true]
        );
        $this->be($user);
        $userToUpdate = factory(\App\User::class)->create();

        $this->put(route('manageUsers.update', [
            'user_id' => $userToUpdate->id,
            'email' => "bar@pfizer.com",
            'is_super_admin' => "1",
        ]))->assertStatus(200);

        $this->assertEquals('1', $userToUpdate->refresh()->is_super_admin);
    }
}
