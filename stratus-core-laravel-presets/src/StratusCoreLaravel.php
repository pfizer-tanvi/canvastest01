<?php

namespace StratusCoreLaravelPresets;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class StratusCoreLaravel
{
    /**
     * The File system
     *
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Creates an instance of this class
     *
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    /**
     * Appends stratus core js to bootstrap file
     *
     * @return boolean
     */
    public function appendStartusCoreJsToBootstrapfile()
    {
        $bootstrapJsPath = resource_path('js/bootstrap.js');

        if (! $this->files->exists($bootstrapJsPath)) {
            return false;
        }

        $bootstrap = $this->files->get($bootstrapJsPath);

        if (Str::contains($bootstrap, './stratus-core.js')) {
            return false;
        }

        $this->files->append($bootstrapJsPath, "require('./stratus-core.js');");

        return true;
    }

    /**
     * Moves the github files
     *
     * @return boolean
     */
    public function copyTemplateFiles()
    {
        return $this->files->copyDirectory(__DIR__ . '/template', base_path());
    }

    /**
     * Installs the stratus core
     */
    public function install()
    {
        $this->copyTemplateFiles();

        $this->updateComposerJsonFile();

        $this->updatePackageJsonFile();
    }

    /**
     * Updates the composer scripts
     *
     * @return boolean
     */
    public function updateComposerJsonFile()
    {
        return $this->updateJsonFileWithStub(
            base_path('composer.json'),
            __DIR__ . '/stubs/composer.stub.json'
        );
    }

    /**
     * Updates the package json files
     *
     * @return boolean
     */
    public function updatePackageJsonFile()
    {
        return $this->updateJsonFileWithStub(
            base_path('package.json'),
            __DIR__ . '/stubs/package.stub.json'
        );
    }

    /**
     * Updates a JSON file with stub
     *
     * @param string $base_file_path
     * @param string $stub_file_path
     *
     * @return boolean
     */
    protected function updateJsonFileWithStub($base_file_path, $stub_file_path)
    {
        if (! $this->files->exists($base_file_path) || ! $this->files->exists($stub_file_path)) {
            return false;
        }

        return JsonFile::createFromPath($base_file_path)
            ->mergeStubFromPath($stub_file_path)
            ->save();
    }
}
