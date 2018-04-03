<?php
/**
 * Created by IntelliJ IDEA.
 * User: dsvenss
 * Date: 2018-04-01
 * Time: 12:26
 */

namespace se\eab\php\laravel\crudgenerator;

use Artisan;

class CrudGenerator
{
    private static $instance;

    const COMMONCLASS_FILENAME = "EABCrudCommon";
    const CRUD_QUALIFIER = "crud";

    private $ctrlpath;
    private $reqpath;
    private $modelspath;

    private function __contstruct()
    {

    }

    /**
     * @return CrudGenerator
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new CrudGenerator();
        }

        return self::$instance;
    }

    public function generateCRUDforModel(array $model)
    {
        $name = $model['name'];
        $namespace = $model['namespace'];
        Artisan::call("backpack:crud", ["name" => $name]);
        $this->removeDefaultGeneratedModel($name);
        $this->adjustCrudController($name);
        $this->appendRoutes($name);
    }

    private function removeDefaultGeneratedModel($name) {
        // TODO implement
    }

    private function adjustCrudController($name) {
        // TODO implement
    }

    private function appendRoutes($name) {
        // TODO implement
    }
}