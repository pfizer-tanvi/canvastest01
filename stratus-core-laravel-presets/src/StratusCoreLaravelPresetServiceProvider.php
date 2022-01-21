<?php

namespace StratusCoreLaravelPresets;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;
use StratusCoreLaravelPresets\Console\Commands\InstallStratusCoreCommand;

class StratusCoreLaravelPresetServiceProvider extends ServiceProvider
{
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            FriendsOfCat\LaravelFeatureFlags\FeatureFlagsProvider::class,
            Pfizer\SecurityAudit\SecurityAuditProvider::class,
            Pfizer\CognitoAuthLaravel\CognitoAuthLaravelServiceProvider::class,
        ];
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->publishes(
            [
                __DIR__ . '/config.php' => config_path('stratus-core-laravel.php'),
            ],
            'stratus-core-laravel-config'
        );

        $this->mergeConfigFrom(__DIR__ . '/config.php', 'stratus-core-laravel');

        if (! optional($this->app)->configurationIsCached()) {
            $this->mergeDefaultConfigIntoApplicationConfig();
        }

        if ($this->app->runningInConsole()) {
            $this->commands([InstallStratusCoreCommand::class]);
        }

        $this->loadStratusRoutes();
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        Schema::defaultStringLength(191);

        $this->app->singleton(StratusCoreLaravel::class, function ($app) {
            return new StratusCoreLaravel(new Filesystem());
        });

        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }

    /**
     * Merge default stratus configuration into the laravel application config
     *
     * @return
     */
    protected function mergeDefaultConfigIntoApplicationConfig()
    {
        foreach (Arr::dot(config('stratus-core-laravel')) as $key => $value) {
            $this->app['config']->set($key, $value);
        }
    }

    /**
     * Loads the stratus custom routes into the laravel application
     */
    protected function loadStratusRoutes(): void
    {
        $path = base_path('routes/stratus.php');

        if (file_exists($path)) {
            $this->loadRoutesFrom($path);
        }
    }
}
