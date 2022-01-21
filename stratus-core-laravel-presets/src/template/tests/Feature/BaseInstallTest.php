<?php

namespace Tests\Feature;

use Tests\TestCase;

class BaseInstallTest extends TestCase
{
    public function testRedirectOnRegister()
    {
        $this->call('GET', '/register')->assertStatus(302);
        $this->call('POST', '/register')->assertStatus(302);
    }
}
