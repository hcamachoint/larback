<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkCloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('product', 'products');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupReorderOperation()
    {
        $this->crud->set('reorder.label', 'name');
        $this->crud->set('reorder.max_level', 2);
    }

    protected function setupListOperation()
    {       
        CRUD::column('name');
        CRUD::column('description');
        CRUD::column('price');
        CRUD::addColumn([
            'label' => 'Category',
            'type' => 'closure',
            'name' => 'categor_id',
            'priority' => 2,
            'function' => function (Product $product) {
                return $product->category_id
                    ? $product->category->name
                    : '';
            }
        ]);
        CRUD::column('created_at');
        CRUD::column('updated_at');
        
        

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProductCreateRequest::class);

        CRUD::field('name');
        CRUD::field('description');
        CRUD::field('price');
        CRUD::addField(['name' => 'price', 'type' => 'number', 'label' => 'Price', 'decimals' => 2]);
        CRUD::addField(['name' => 'category_id', 'type' => 'relationship', 'label' => 'Category']);
        //CRUD::addField(['name' => 'category_id', 'type' => 'relationship', 'label' => 'Category', 'inline_create' => ['entity' => 'category', 'force_select' => true, 'modal_class' => 'modal-dialog modal-xl'],'placeholder' => "Selecciona una cocina"]);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
        CRUD::setValidation(ProductUpdateRequest::class);
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        CRUD::column('name');
        CRUD::column('description');
        CRUD::column('price');
        CRUD::addColumn([
            'label' => 'Category',
            'type' => 'closure',
            'name' => 'categor_id',
            'priority' => 2,
            'function' => function (Product $product) {
                return $product->category_id
                    ? $product->category->name
                    : '';
            }
        ]);
        CRUD::column('created_at');
        CRUD::column('updated_at');
    }
}
