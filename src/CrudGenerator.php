<?php
/**
 * Created by IntelliJ IDEA.
 * User: dsvenss
 * Date: 2018-04-04
 * Time: 15:09
 */

namespace se\eab\php\laravel\crudgenerator;


abstract class CrudGenerator
{
    const CRUD_QUALIFIER = "crud";
    const TRANSLATABLE_QUALIFIER = "translatable";

    abstract function generateModelCruds();

    abstract function generateCrudForModel(array $model, $namespace);
}