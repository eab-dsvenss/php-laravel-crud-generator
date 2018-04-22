<?php namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\TestModelCrudRequest as StoreRequest;
use App\Http\Requests\TestModelCrudRequest as UpdateRequest;

class TestModelCrudController extends CrudController {

    public function setup() {
        $this->crud->setModel('App\Models\TestModel');
        $this->crud->setRoute(config('backpack.base.route_prefix')  . '/testmodel');
        $this->crud->setEntityNameStrings('testmodel', 'testmodels');

        $this->crud->setColumns(['name']);
        $this->crud->addField([
            'name' => 'name',
            'label' => 'Test Model name'
        ]);
    }

    public function store(StoreRequest $request)
    {
        return parent::storeCrud();
    }

    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }
}