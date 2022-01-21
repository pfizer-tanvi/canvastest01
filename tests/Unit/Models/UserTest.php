<?php

namespace Tests\Unit\Models;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testIsAdmin(): void
    {
        $user = new User();
        $this->assertFalse($user->isAdmin());

        $user->is_super_admin = true;
        $this->assertTrue($user->isAdmin());
    }
}
