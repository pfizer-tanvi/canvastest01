<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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
}
