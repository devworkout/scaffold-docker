<?php

namespace DevWorkout\ScaffoldDocker;

use Afterflow\Framework\Console\Commands\ScaffoldCommand;
use DevWorkout\ScaffoldDocker\Scaffolders\MultiScaffolder;
use DevWorkout\ScaffoldDocker\Scaffolders\ScaffoldDocker;
use Illuminate\Support\ServiceProvider;

class ScaffoldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->app->tag(ScaffoldDocker::class, ['afterflow-scaffolder', 'devworkout/scaffold-docker']);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}