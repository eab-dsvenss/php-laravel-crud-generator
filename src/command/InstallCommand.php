<?php
/**
 * Created by IntelliJ IDEA.
 * User: dsvenss
 * Date: 2018-04-01
 * Time: 12:27
 */

namespace se\eab\php\laravel\crudgenerator\command;


use Illuminate\Console\Command;
use Artisan;
use se\eab\php\classtailor\factory\ClassFileFactory;
use se\eab\php\laravel\crudgenerator\BackpackCrudGenerator;
use se\eab\php\laravel\modelgenerator\config\ModelGeneratorConfigHelper;

class InstallCommand extends Command
{
    protected $signature = 'eab-crudgenerator:install {--type=}';

    protected $description = "Install the package and all dependencies";

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->call("eab-modelgenerator:install");

        switch ($this->option('type')) {
            case "backpack":
                $this->installBackpack();
                break;
            default:
                $this->installBackpack();
                break;
        }
    }

    private function installBackpack()
    {
        $this->call("eab-modelgenerator:install");
        $this->call("backpack:base:install");
        $this->call("backpack:crud:install");
        $this->call("vendor:publish", ["--provider" => "Spatie\\Translatable\\TranslatableServiceProvider\\"]);

        $baseclassadjustments = [
            ClassFileFactory::TRAITS_KEY => [
                [ClassFileFactory::NAME_KEY => "CrudTrait", ClassFileFactory::DEPENDENCY_KEY => "Backpack\\CRUD\\CrudTrait"],
            ]
        ];

        $translatableadjustements = [
            ClassFileFactory::TRAITS_KEY => [
                [ClassFileFactory::NAME_KEY => "HasTranslations", ClassFileFactory::DEPENDENCY_KEY => "Spatie\\Translatable\\HasTranslations"],
            ]
        ];


        ModelGeneratorConfigHelper::getInstance()->saveExtraModelAdjustmentsToFile($baseclassadjustments, BackpackCrudGenerator::CRUD_QUALIFIER);
        ModelGeneratorConfigHelper::getInstance()->saveExtraModelAdjustmentsToFile($translatableadjustements, BackpackCrudGenerator::TRANSLATABLE_QUALIFIER);

    }
}