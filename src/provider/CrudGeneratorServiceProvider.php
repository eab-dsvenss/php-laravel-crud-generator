<?php

namespace se\eab\php\laravel\modelgenerator\provider;

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
        $this->publishes([
            $this->basepath . "config" . DIRECTORY_SEPARATOR . self::CONFIG_FILENAME . ".php" => config_path(self::CONFIG_FILENAME . '.php'),
            $this->basepath . "config" . DIRECTORY_SEPARATOR . self::DUMMY_ADJUSTMENT_FILENAME => config_path(self::MODEL_ADJUSTMENTS_FOLDERNAME . DIRECTORY_SEPARATOR . self::DUMMY_ADJUSTMENT_FILENAME)
        ]);
        
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

    }

}
