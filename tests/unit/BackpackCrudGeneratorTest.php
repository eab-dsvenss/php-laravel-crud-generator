<?php
/**
 * Created by IntelliJ IDEA.
 * User: dsvenss
 * Date: 2018-04-12
 * Time: 15:38
 */

use se\eab\php\laravel\crudgenerator\BackpackCrudGenerator;
use se\eab\php\laravel\modelgenerator\config\ModelGeneratorConfigHelper;
use se\eab\php\laravel\crudgenerator\CrudGenerator;
use AspectMock\Test as test;

class_alias("Illuminate\\Support\\Facades\\Artisan", "Artisan");
class_alias("Illuminate\\Support\\Facades\\Log", "Log");

class BackpackCrudGeneratorTest extends \Codeception\Test\Unit
{

    /**
     * @var \UnitTester
     */
    protected $tester;

    private $modelName = "TestModel";
    private $routefilename = "route";
    private $model;
    private $namespace;

    protected function _before()
    {
        parent::_before();

        $this->setupTestData();
    }

    protected function _after()
    {
        parent::_after();
    }

    /**
     * @throws Exception
     */
    private function setupCommonMock()
    {

        test::double("Illuminate\Support\Facades\Artisan", ["call" => "test"]);
        test::func('se\eab\php\laravel\modelgenerator\config', "config_path", "configpath");
        test::func('se\eab\php\laravel\crudgenerator\model', "app_path", codecept_data_dir());
        test::func('se\eab\php\laravel\crudgenerator\controller', "app_path", codecept_data_dir());
        test::func('se\eab\php\laravel\crudgenerator\route', "app_path", codecept_data_dir("route.php"));

        test::double('se\eab\php\laravel\modelgenerator\config\ModelGeneratorConfigHelper', ["getNamespace" => $this->namespace]);
    }

    /**
     * @throws Exception
     */
    protected function setupSingleModelMock()
    {
        $this->setupCommonMock();
        // CONTINUE

    }

    /**
     * @throws Exception
     */
    protected function setupMultipleModelsMock()
    {
        $this->setupCommonMock();
        // CONTINUE
    }

    protected function setupTestData()
    {
        copy(codecept_data_dir($this->modelName . "_COPY.php"), codecept_data_dir($this->modelName . ".php"));
        copy(codecept_data_dir($this->modelName . "CrudController_COPY.php"), codecept_data_dir($this->modelName . "CrudController.php"));
        copy(codecept_data_dir($this->routefilename . "_COPY.php"), codecept_data_dir($this->routefilename . ".php"));

        $this->namespace = "namespace";
        $this->model = [
            ModelGeneratorConfigHelper::MODELNAME_KEY => $this->modelName,
            ModelGeneratorConfigHelper::MODELTABLE_KEY => "modeltable",
            ModelGeneratorConfigHelper::MODELEXTRAS_KEY => [
                CrudGenerator::CRUD_QUALIFIER
            ]
        ];
    }

    /**
     * @throws Exception
     */
    public function testGenerateCrudForModel()
    {
        $this->assertTrue(file_exists(codecept_data_dir($this->modelName . ".php")));

        $this->setupSingleModelMock();
        $bpgen = BackpackCrudGenerator::getInstance();
        $bpgen->generateCrudForModel($this->model, $this->namespace);

        $this->assertFalse(file_exists(codecept_data_dir($this->modelName . ".php")));
        $controllercontent = file_get_contents(codecept_data_dir($this->modelName . "CrudController.php"));
        $this->assertFalse(strpos($controllercontent, "App\\Models\\" . $this->modelName));
        $this->assertTrue(strpos($controllercontent, $this->namespace . "\\" . $this->modelName) != FALSE);
        $routecontent = file_get_contents(codecept_data_dir($this->routefilename . ".php"));
        $this->assertTrue(strpos($routecontent, "CRUD::resource('" . strtolower($this->modelName) . "', '" . $this->modelName . "CrudController');") != FALSE);
    }

    /**
     * @throws Exception
     */
    /*public function testGenerateModelCruds()
    {
        //$this->setupMultipleModelsMock();
        //$bpgen = BackpackCrudGenerator::getInstance();
        //$bpgen->generateModelCRUDs();

    }*/
}
