<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ManageUsersCreateTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    public function testCreate()
    {
        $user = factory(\App\User::class)->create(
            ['is_super_admin' => 1]
        );
        $this->be($user);
        $this->post(route('manageUsers.create', [
            'email' => "foo@pfizer.com",
            'is_super_admin' => 0
        ]))->assertStatus(200);

        $this->assertDatabaseHas('users', ['email' => 'foo@pfizer.com', 'is_super_admin' => 0]);
    }

    public function testCreateAdmin()
    {
        $user = factory(\App\User::class)->create(
            ['is_super_admin' => true]
        );
        $this->be($user);
        $this->post(route('manageUsers.create', [
            'email' => "foo@pfizer.com",
            'is_super_admin' => "1"
        ]))->assertStatus(200);

        $this->assertDatabaseHas('users', ['email' => 'foo@pfizer.com', 'is_super_admin' => 1]);
    }

    public function testFailValidate()
    {
        $user = factory(\App\User::class)->create(
            ['is_super_admin' => 1]
        );
        $this->be($user);
        $this->post(route('manageUsers.create', [
            'email' => "foo@foo.com",
            'is_super_admin' => 0
        ]))->assertStatus(302);
    }
}
