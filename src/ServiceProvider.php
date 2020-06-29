<?php

namespace PurpleMountain\Helpers;

use Illuminate\FileSystem\FileSystem;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use PurpleMountain\Helpers\Commands\AttachRoleToUser;
use PurpleMountain\Helpers\Commands\CreateApiToken;
use PurpleMountain\Helpers\Commands\CreateUser;
use PurpleMountain\Helpers\Commands\MakeModelResource;
use PurpleMountain\Helpers\Commands\SyncPermissions;
use PurpleMountain\Organisations\Providers\EventServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /** 
     * Put together the path to the config file.
     *
     * @return string
     */
    private function configPath(): string
    {
        return __DIR__.'/../config/' . $this->shortName() . '.php';
    }

    /** 
     * Get the short name for this package.
     *
     * @return string
     */
    private function shortName(): string
    {
        return 'helpers';
    }


    /**
     * Bootstrap the package.
     *
     * @return void
     */
    public function boot()
    {
        $this->handleRoutes();
        $this->handleConfigs();

        if (env('APP_ENV') === 'local') {
            $this->handleMigrations();
        }

        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateUser::class,
                AttachRoleToUser::class,
                MakeModelResource::class,
                SyncPermissions::class,
                CreateApiToken::class
            ]);
        }
    }

    /**
     * Register anything this package needs.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom($this->configPath(), $this->shortName());

        $this->app->register(EventServiceProvider::class);
    }

    /** 
     * Register any migrations.
     *
     * @return void
     */
    private function handleMigrations()
    {
        $this->publishes([
            __DIR__.'/../database/migrations/default.php.stub' => database_path('migrations/2020_03_15_000000_default.php')
        ], $this->shortName() . '-migrations');
    }

    /** 
     * Register any routes this package needs.
     *
     * @return void
     */
    private function handleRoutes()
    {
        Route::group([
            'name' => $this->shortName(),
            'namespace' => 'PurpleMountain\Helpers\Http\Controllers',
            'middleware' => ['web']
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    /** 
     * Register any config files this package needs.
     *
     * @return void
     */
    private function handleConfigs()
    {
        $this->publishes([
            $this->configPath(),
            $this->shortName() . '-config'
        ], $this->shortName() . '-config');
    }

}