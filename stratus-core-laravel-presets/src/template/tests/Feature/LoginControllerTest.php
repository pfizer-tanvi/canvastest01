<?php

namespace Tests\Feature;

use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    /**
     * @covers \App\Http\Controllers\Auth\LoginController::showLoginForm
     */
    public function testLoginPage()
    {
        $this->get('/login')->assertStatus(200)->assertSee('Disclaimer');
    }
}
