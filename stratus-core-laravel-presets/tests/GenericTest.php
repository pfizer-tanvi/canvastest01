<?php

namespace Tests;

use Illuminate\Support\Facades\Route;

class GenericTest extends TestCase
{
    public function testListsAvailableRoutesSuccessFully()
    {
        $this->artisan('route:list', [
            '--columns' => ['uri'],
        ])->assertExitCode(0);
    }

    public function testItRegistersTheLoginRoute()
    {
        $this->assertTrue(Route::has('login'));
    }
}
