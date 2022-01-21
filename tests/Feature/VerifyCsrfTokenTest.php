<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class VerifyCsrfTokenTest extends TestCase
{
    use RefreshDatabase;

    public function testTokenLogic()
    {
        $this->partialMock(VerifyCsrfToken::class, function ($mock) {
            $mock->shouldAllowMockingProtectedMethods()
                ->shouldReceive("isReading")->andReturn(false);
            $mock->shouldAllowMockingProtectedMethods()
                ->shouldReceive("runningUnitTests")->andReturn(false);
            $mock->shouldAllowMockingProtectedMethods()
                ->shouldReceive("inExceptArray")->andReturn(false);
            $mock->shouldAllowMockingProtectedMethods()
                ->shouldReceive("getTokenFromRequest")->once()->andReturn("foo");
        });
        $user = \App\Models\User::factory()->create();
        $this->be($user);
        $this->post("/api/example")->assertStatus(302)->assertSessionHasErrors();
    }
}
