<?php
/**
 * Created by IntelliJ IDEA.
 * User: dsvenss
 * Date: 2018-04-04
 * Time: 13:57
 */

namespace se\eab\php\laravel\crudgenerator\route;


use se\eab\php\classtailor\model\FileHandler;
use se\eab\php\laravel\crudgenerator\controller\ControllerHandler;

class RouteHandler
{
    private static $instance;

    private $routesfile;

    private function __construct()
    {
        $this->routesfile = "routes/admin.php";
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new RouteHandler();
        }

        return self::$instance;
    }

    public function appendRoute($modelname)
    {
        $path = strtolower($modelname);
        $routestr = "CRUD::resource('$path', '" . $modelname . ControllerHandler::CONTROLLER_BASENAME . "');";
        if (file_exists($this->routesfile)) {
            $this->handleExistingRoutesfile($routestr);
        } else {
            $this->createNewRoutesFile($routestr);
        }
    }

    private function createNewRoutesFile($routestr)
    {
        FileHandler::getInstance()->writeToFile($this->routesfile, $routestr);
    }

    private function handleExistingRoutesfile($routestr)
    {
        $routescontent = FileHandler::getInstance()->getFileContents($this->routesfile);
        if (strpos($routescontent, $routestr) === FALSE) {
            FileHandler::getInstance()->appendToFile($this->routesfile, $routestr);
        }
    }
}