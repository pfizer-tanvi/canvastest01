<?php

namespace Tests;

class InstallStratusCoreCommandTest extends TestCase
{
    public function testInstallStratusCoreCommandRunSuccessfull()
    {
        $this->artisan('stratus-core-laravel:install')
            ->assertExitCode(0)
            ->expectsOutput('Stratus core laravel installed  successfully!');
    }
}
