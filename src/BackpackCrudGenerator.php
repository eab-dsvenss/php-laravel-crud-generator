<?php
/**
 * Created by IntelliJ IDEA.
 * User: dsvenss
 * Date: 2018-04-01
 * Time: 12:26
 */

namespace se\eab\php\laravel\crudgenerator;

use Artisan;
use se\eab\php\laravel\crudgenerator\controller\ControllerHandler;
use se\eab\php\laravel\crudgenerator\model\ModelHandler;
use se\eab\php\laravel\crudgenerator\route\RouteHandler;
use se\eab\php\laravel\modelgenerator\config\ModelGeneratorConfigHelper;

class BackpackCrudGenerator extends CrudGenerator
{
    private static $instance;

    private function __construct()
    {

    }

    /**
     * @return BackpackCrudGenerator
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new BackpackCrudGenerator();
        }

        return self::$instance;
    }

    public function generateModelCRUDs()
    {
        $namespace = ModelGeneratorConfigHelper::getInstance()->getNamespace();

        foreach (ModelGeneratorConfigHelper::getInstance()->getModels() as $model) {
            if (ModelGeneratorConfigHelper::getInstance()->hasExtrasQualifier($model, CrudGenerator::CRUD_QUALIFIER)) {
                $this->generateCRUDforModel($model, $namespace);
            }
        }
    }

    public function generateCRUDforModel(array $model, $namespace)
    {
        $name = $model[ModelGeneratorConfigHelper::MODELNAME_KEY];
        Artisan::call("backpack:crud", ["name" => $name]);
        $this->removeDefaultGeneratedModel($name);
        $this->adjustCrudController($name, $namespace);
        $this->appendRoutes($name);
    }

    private function removeDefaultGeneratedModel($name)
    {
        ModelHandler::getInstance()->removeDefaultGeneratedModel($name);
    }

    private function adjustCrudController($name, $namespace)
    {
        ControllerHandler::getInstance()->adjustController($name, $namespace);
    }

    private function appendRoutes($name)
    {
        RouteHandler::getInstance()->appendRoute($name);
    }
}