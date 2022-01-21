<?php

namespace Tests\Unit;

use Facades\App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use \App\Models\User as UserModel;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers App\Models\User
     */
    public function testUser()
    {
        $user = \App\Models\User::factory()->create();
        $this->assertNotNull($user->email);
    }

    public function testCreateUser()
    {
        $user = User::createUser([
            'email' => "foo@foo.com",
        ]);

        $this->assertInstanceOf(UserModel::class, $user);

        $this->assertDatabaseHas('users', ['email' => "foo@foo.com"]);
    }

    public function testAdminUserAttribute()
    {
        $user = User::createUser([
            'email' => "fooadmin@foo.com",
            'is_super_admin' => "1",
        ]);

        $this->assertInstanceOf(UserModel::class, $user);

        $this->assertDatabaseHas('users', ['email' => "fooadmin@foo.com", 'is_super_admin' => 1]);
    }

    public function testCreateAdminUser()
    {
        $user = User::createUser([
            'email' => "fooadmin@foo.com",
            'is_super_admin' => "1",
        ]);
        $this->be($user);
        $this->assertTrue($user->isAdmin());
    }

    public function testAdminUserAttributeFalse()
    {
        $user = User::createUser([
            'email' => "fooadmin@foo.com",
        ]);
        $this->be($user);
        $this->assertFalse($user->isAdmin());
    }

}
