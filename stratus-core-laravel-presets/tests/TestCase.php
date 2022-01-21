<?php

namespace Tests;

use Illuminate\Filesystem\Filesystem;
use Laravel\Ui\UiServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use StratusCoreLaravelPresets\StratusCoreLaravelPresetServiceProvider;

abstract class TestCase extends BaseTestCase
{
    /**
     * The files
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->files = new Filesystem();

        $this->app->setBasePath($basePath = __DIR__ . '/app');

        $this->files->ensureDirectoryExists($basePath);
    }

    /**
     * Gets package providers
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [UiServiceProvider::class, StratusCoreLaravelPresetServiceProvider::class];
    }

    /**
     * Clean up the testing environment before the next test.
     */
    protected function tearDown(): void
    {
        $this->files->cleanDirectory(__DIR__ . '/app');

        parent::tearDown();
    }
}
