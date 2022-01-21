<?php

namespace Tests;

use StratusCoreLaravelPresets\StratusCoreLaravelPresetServiceProvider;

class StratusCoreLaravelPresetServiceProviderTest extends TestCase
{
    public function testItMergesTheLaravelStratusCoreConfigIntoTheApplicationConfig()
    {
        $this->app['config']->set('stratus-core-laravel', [
            'app' => [
                'dummy-key' => 'dummy-value',
            ],
        ]);

        // re-register the provider to have the boot method rerun
        $this->app->register(StratusCoreLaravelPresetServiceProvider::class, $force = true);

        $this->assertEquals($this->app['config']['app']['dummy-key'], 'dummy-value');
    }
}
