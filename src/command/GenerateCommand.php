<?php
/**
 * Created by IntelliJ IDEA.
 * User: dsvenss
 * Date: 2018-04-01
 * Time: 12:27
 */

namespace se\eab\php\laravel\crudgenerator\command;


use Illuminate\Console\Command;
use se\eab\php\laravel\crudgenerator\BackpackCrudGenerator;

class GenerateCommand extends Command
{
    protected $signature = 'eab-crudgenerator:generate {--type=}';

    protected $description = "Generate CRUD structure for models";

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        switch ($this->option("type")) {

            case "backpack":
                $this->generateBackpack();
                break;

            default:
                $this->generateBackpack();
                break;
        }
    }

    private function generateBackpack()
    {
        $this->call("eab-modelgenerator:generate");
        $crudgen = BackpackCrudGenerator::getInstance();

        $crudgen->generateModelCruds();
    }
}