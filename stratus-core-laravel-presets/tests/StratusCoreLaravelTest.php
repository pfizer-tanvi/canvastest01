<?php

namespace Tests;

use StratusCoreLaravelPresets\StratusCoreLaravel;

class StratusCoreLaravelTest extends TestCase
{
    /**
     * The stratus core
     *
     * @var \StratusCoreLaravelPreset\StratusCoreLaravel
     */
    protected $stratusCore;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->stratusCore = app(StratusCoreLaravel::class);
    }

    public function testItCopiesTemplateFilesToTheBaseDirectorySuccessFully()
    {
        $this->assertTrue($this->stratusCore->copyTemplateFiles());
    }

    public function testItUpdatesTheComposerJsonFileWithTemplateStubScripts()
    {
        $this->files->put($this->app->basePath('composer.json'), '{}');

        $this->stratusCore->updateComposerJsonFile();

        $stub = json_decode($this->files->get(__DIR__ . '/../src/stubs/composer.stub.json'), true);

        $existing = json_decode($this->files->get($this->app->basePath('composer.json')), true);

        $this->assertSame($stub['scripts'], $existing['scripts']);
    }

    public function testItUpdatesThePackageJsonWithJestConfig()
    {
        $this->files->put($this->app->basePath('package.json'), '{}');

        $this->stratusCore->updatePackageJsonFile();

        $stub = json_decode($this->files->get(__DIR__ . '/../src/stubs/package.stub.json'), true);

        $existing = json_decode($this->files->get($this->app->basePath('package.json')), true);

        $this->assertSame($stub['jest'], $existing['jest']);
    }

    public function testItAppendsTheStratusCoreJsToTheBootstrapFileIfItExists()
    {
        $this->ensureResourceJsDirectoryExists();

        $this->files->put(resource_path('js/bootstrap.js'), '');

        $this->assertTrue($this->stratusCore->appendStartusCoreJsToBootstrapfile());
    }

    protected function ensureResourceJsDirectoryExists()
    {
        if (! $this->files->isDirectory(resource_path('js'))) {
            $this->files->makeDirectory(resource_path('js'), 0777, true);
        }
    }
}
