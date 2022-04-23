<?php

namespace Spatie\Permission;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Routing\Route;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class ApiauthServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
    }

    protected function offerPublishing()
    {
//        if (! function_exists('config_path')) {
//            // function not available and 'publish' not relevant in Lumen
//            return;
//        }

        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        $this->publishes([
            __DIR__.'/../config/apiauth.php' => config_path('apiauth.php'),
        ]);
//        $this->publishes([
//            __DIR__.'/../controllers/Ap.php' => config_path('permission.php'),
//        ], 'config');
//
//        $this->publishes([
//            __DIR__.'/../database/migrations/create_permission_tables.php.stub' => $this->getMigrationFileName('create_permission_tables.php'),
//        ], 'migrations');
    }

    protected function getMigrationFileName($migrationFileName): string
    {
        $timestamp = date('Y_m_d_His');

        $filesystem = $this->app->make(Filesystem::class);

        return Collection::make($this->app->databasePath().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR)
            ->flatMap(function ($path) use ($filesystem, $migrationFileName) {
                return $filesystem->glob($path.'*_'.$migrationFileName);
            })
            ->push($this->app->databasePath()."/migrations/{$timestamp}_{$migrationFileName}")
            ->first();
    }
}
