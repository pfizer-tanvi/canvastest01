<?php

namespace Tests\Integration\Http\Middleware;

use App\Http\Middleware\EnsureUserIsAdministrator;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Mockery;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Tests\TestCase;

class EnsureUserIsAdministratorTest extends TestCase
{
    use RefreshDatabase;

    /** @var \App\Http\Middleware\EnsureUserIsAdministrator */
    protected $middleware;

    /** @var \Mockery\MockInterface */
    protected $user;

    /** @var \Illuminate\Http\Request */
    protected $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->middleware = new EnsureUserIsAdministrator();

        $this->user = Mockery::mock(User::class);

        $this->request = tap(Request::create('/'), function (Request $request) {
            $request->setUserResolver(function () {
                return $this->user;
            });
        });
    }

    public function testHandleWithAdminstrator(): void
    {
        $this->user->shouldReceive('isAdmin')->andReturn(true);

        $response = $this->middleware->handle($this->request, function () {
            return 'foo';
        });

        $this->assertEquals('foo', $response);
    }

    public function testHandleWithNonAdministrator(): void
    {
        $this->user->shouldReceive('isAdmin')->andReturn(false);

        $this->expectException(AccessDeniedHttpException::class);

        $this->middleware->handle($this->request, function () {
            $this->fail('Middleware unexpectedly handled request');
        });
    }
}
