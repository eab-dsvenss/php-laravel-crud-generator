<?php

namespace se\eab\php\laravel\crudgenerator\provider;

use Illuminate\Support\ServiceProvider;
use se\eab\php\laravel\crudgenerator\command\GenerateCommand;
use se\eab\php\laravel\crudgenerator\command\InstallCommand;

class CrudGeneratorServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {



       if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                GenerateCommand::class
            ]);
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        if (class_exists('se\eab\php\laravel\modelgenerator\provider\ModelGeneratorServiceProvider')) {
            $this->app->register('se\eab\php\laravel\modelgenerator\provider\ModelGeneratorServiceProvider');
        }
    }

}
