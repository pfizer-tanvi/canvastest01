<?php

namespace Tests\Unit;

use \App\User as UserModel;
use Facades\App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers App\User
     */
    public function testUser()
    {
        $user = factory(\App\User::class)->create();
        $this->assertNotNull($user->email);
    }

    public function testCreateUser()
    {
        $user = User::createUser([
            'email' => "foo@foo.com"
        ]);

        $this->assertInstanceOf(UserModel::class, $user);

        $this->assertDatabaseHas('users', ['email' => "foo@foo.com"]);
    }

    public function testCreateAdminUser()
    {
        $user = User::createUser([
            'email' => "fooadmin@foo.com",
            'is_super_admin' => "1"
        ]);

        $this->assertInstanceOf(UserModel::class, $user);

        $this->assertDatabaseHas('users', ['email' => "fooadmin@foo.com", 'is_super_admin' => 1]);
    }

    public function testUserRoleFactory()
    {
        $user = factory(\App\User::class)->state("withRole")->create();
        $this->assertNotNull($user->roles->toArray());
    }
}
