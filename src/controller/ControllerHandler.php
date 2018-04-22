<?php
/**
 * Created by IntelliJ IDEA.
 * User: dsvenss
 * Date: 2018-04-04
 * Time: 14:02
 */

namespace se\eab\php\laravel\crudgenerator\controller;

use se\eab\php\classtailor\ClassTailor;
use se\eab\php\classtailor\factory\ClassFileFactory;

class ControllerHandler
{
    private static $instance;
    private $ctrlpath;
    private $classtailor;
    const CONTROLLER_BASENAME = "CrudController";

    private function __construct()
    {
        $this->ctrlpath = app_path("Http/Controllers/Admin");
        $this->classtailor = new ClassTailor();
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new ControllerHandler();
        }

        return self::$instance;
    }

    public function adjustController($name, $namespace)
    {
        $classfile = ClassFileFactory::getInstance()->createClassfileFromArray([
            ClassFileFactory::PATH_KEY => $this->ctrlpath . DIRECTORY_SEPARATOR . $name . self::CONTROLLER_BASENAME . ".php",
            ClassFileFactory::REPLACEABLES_KEY => [
                [ClassFileFactory::PATTERN_KEY => "App\\\\Models\\\\$name", ClassFileFactory::REPLACEMENT_KEY => $namespace . "\\\\$name"]
            ]
        ]);
        $this->classtailor->tailorClass($classfile);
    }


}