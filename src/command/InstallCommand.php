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
use se\eab\php\classtailor\model\ClassFile;
use se\eab\php\laravel\crudgenerator\CrudGenerator;
use se\eab\php\laravel\modelgenerator\config\ModelGeneratorConfigHelper;
use se\eab\php\laravel\modelgenerator\ModelGenerator;

class InstallCommand extends Command
{
    protected $signature = 'eab-crudgenerator:install {--type=}';

    protected $description = "Install the package and all dependencies";

    public function __construct()
    {
        parent::__construct();
    }

    public function handle() {
        Artisan::call("eab-modelgenerator:install");

        switch($this->option('type')) {
            case "backpack":
                $this->installBackpack();
                break;
            default:
                $this->installBackpack();
                break;
        }
    }

    private function installBackpack() {
        Artisan::call("eab-modelgenerator:install");
        Artisan::call("backpack:base:install");
        Artisan::call("backpack:crud:install");

        $baseclassadjustments = [
            ClassFileFactory::CLASSNAME_KEY => CrudGenerator::COMMONCLASS_FILENAME,
            ClassFileFactory::TRAITS_KEY => [[ClassFileFactory::NAME_KEY => "CrudTrait", ClassFileFactory::DEPENDENCY_KEY => "Backpack\\CRUD\\CrudTrait"]]
        ];

        ModelGeneratorConfigHelper::getInstance()->saveExtraModelAdjustmentsToFile($baseclassadjustments, CrudGenerator::CRUD_QUALIFIER);
    }
}