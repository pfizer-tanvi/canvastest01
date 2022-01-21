<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BaseInstallTest extends TestCase
{

    public function testRedirectOnRegister()
    {
        $this->call("GET", "/register")->assertStatus(302);
        $this->call("POST", "/register")->assertStatus(302);
    }
}
