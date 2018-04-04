<?php
/**
 * Created by IntelliJ IDEA.
 * User: dsvenss
 * Date: 2018-04-01
 * Time: 12:26
 */

namespace se\eab\php\laravel\crudgenerator;

use Artisan;
use Log;
use se\eab\php\classtailor\ClassTailor;
use se\eab\php\laravel\crudgenerator\controller\ControllerHandler;
use se\eab\php\laravel\crudgenerator\model\ModelHandler;
use se\eab\php\laravel\crudgenerator\route\RouteHandler;

class BackpackCrudGenerator
{
    private static $instance;

    const COMMONCLASS_FILENAME = "EABCrudCommon";
    const CRUD_QUALIFIER = "crud";


    /**
     * @var ClassTailor
     */
    private $classtailor;

    private function __contstruct()
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

    public function generateCRUDforModel(array $model)
    {
        $name = $model['name'];
        $namespace = $model['namespace'];
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