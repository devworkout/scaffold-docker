<?php

namespace DevWorkout\ScaffoldDocker;

use Afterflow\Framework\Console\Commands\ScaffoldCommand;
use Afterflow\Framework\ScaffolderDiscovery;
use DevWorkout\ScaffoldDocker\Scaffolders\MultiScaffolder;
use DevWorkout\ScaffoldDocker\Scaffolders\ScaffoldDocker;
use Illuminate\Support\ServiceProvider;

class ScaffoldServiceProvider extends ServiceProvider implements ScaffolderDiscovery
{

    public static function scaffolders(): array
    {
        return [
            ScaffoldDocker::class,
        ];
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}