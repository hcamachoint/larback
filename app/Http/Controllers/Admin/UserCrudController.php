<?php namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\UserRequest;

class UserCrudController extends CrudController {

  use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
  use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
  use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
  use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
  use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
  //use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation;
  use \Backpack\CRUD\app\Http\Controllers\Operations\BulkCloneOperation;
  use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
  use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

  public function setup() 
  {
      $this->crud->setModel("App\Models\User");
      $this->crud->setRoute("admin/user");
      $this->crud->setEntityNameStrings('user', 'users');
      $this->crud->enableBulkActions();
      $this->crud->addFilter([ 
            'type'  => 'simple',
            'name'  => 'name',
            'label' => 'Name'
        ],
        false, 
        function() {});
        $this->crud->addFilter([ 
            'type'  => 'simple',
            'name'  => 'email',
            'label' => 'Email'
        ],
        false, 
        function() {}
      );
  }

  protected function setupReorderOperation()
  {
      $this->crud->set('reorder.label', 'name');
      $this->crud->set('reorder.max_level', 2);
  }

  public function setupListOperation()
  {
      $this->crud->column('name');
      $this->crud->column('email');
      $this->crud->column('created_at');
      $this->crud->addButtonFromModelFunction('line', 'open_google', 'openGoogle', 'beginning');
  }

  public function setupCreateOperation()
  {
      $this->crud->setValidation(UserRequest::class);

      $this->crud->addField([
        'name' => 'name',
        'type' => 'text',
        'label' => "Name"
      ]);
      $this->crud->addField([
        'name' => 'email',
        'type' => 'text',
        'label' => "Email"
      ]);
      $this->crud->addField([
        'name' => 'password',
        'type' => 'password',
        'label' => "Password"
      ]);
  }

  public function setupUpdateOperation()
  {
      $this->setupCreateOperation();
  }
}