<?php

namespace StratusCoreLaravelPresets\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use InvalidArgumentException;
use Laravel\Ui\Presets\Vue;
use StratusCoreLaravelPresets\StratusCoreLaravel;

class InstallStratusCoreCommand extends Command
{
    /**
     * The stratus core
     *
     * @var \StratusCoreLaravelPresets\StratusCoreLaravel
     */
    protected $stratusCore;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stratus-core-laravel:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs the stratus-laravel-core preset';

    /**
     * Create a new command instance.
     */
    public function __construct(StratusCoreLaravel $stratusCore)
    {
        parent::__construct();

        $this->stratusCore = $stratusCore;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('<comment>Installing Vue template files</comment>');

        Vue::install();

        $this->info('<comment>Copying template files</comment>');

        $this->stratusCore->copyTemplateFiles();

        $this->info('<comment>Updating composer json </comment>');

        $this->stratusCore->updateComposerJsonFile();

        $this->info('<comment>Updating package.json </comment>');

        $this->stratusCore->updatePackageJsonFile();

        $this->info('<comment>Appending stratus-core.js to bootstrap.js </comment>');

        $this->stratusCore->appendStartusCoreJsToBootstrapfile();

        $this->info('<comment>Creating session & cache table migrations </comment>');

        $this->createSessionAndCacheDatabaseMigrations();

        $this->info('<comment>Installing dusk</comment>');

        Artisan::call('dusk:install');

        $this->info('Stratus core laravel installed  successfully!');
    }

    /**
     * Creates session migration
     */
    protected function createSessionAndCacheDatabaseMigrations()
    {
        try {
            Artisan::call('session:table');
            Artisan::call('cache:table');
        } catch (InvalidArgumentException $e) {
        }
    }
}
