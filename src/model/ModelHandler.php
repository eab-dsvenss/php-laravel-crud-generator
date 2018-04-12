<?php
/**
 * Created by IntelliJ IDEA.
 * User: dsvenss
 * Date: 2018-04-04
 * Time: 14:06
 */

namespace se\eab\php\laravel\crudgenerator\model;

use Log;

class ModelHandler
{
    private $modelspath;
    private static $instance;

    private function __construct()
    {
        $this->modelspath = app_path("Models");
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new ModelHandler();
        }

        return self::$instance;
    }

    public function removeDefaultGeneratedModel($name)
    {
        if (!unlink($this->modelspath . DIRECTORY_SEPARATOR . "$name.php")) {
            Log::warning("Could not remove model: $name");
        }
    }
}