<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ResearchRepositoryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class ResearchRepositoryCrudController extends CrudController {
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup() {
        CRUD::setModel(\App\Models\ResearchRepository::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/research-repository');
        CRUD::setEntityNameStrings('research project', 'research projects');
    }

    protected function setupListOperation() {
        CRUD::column('project_name');
        CRUD::column('members');
        CRUD::column('department');
        CRUD::column('abstract');
        CRUD::column('approved')->type('boolean');
        CRUD::column('rejected')->type('boolean');
        CRUD::column('rejection_reason');

        // Display banner image in list
        CRUD::addColumn([
            'name' => 'banner_image',
            'label' => 'Banner Image',
            'type' => 'image',
            'prefix' => 'storage/' 
        ]);

        // Clickable PDF file link
        CRUD::addColumn([
            'name' => 'file',
            'label' => 'File',
            'type' => 'closure',
            'function' => function($entry) {
                if ($entry->file) {
                    return '<a href="'.asset('storage/'.$entry->file).'" target="_blank">View PDF</a>';
                }
                return 'No file uploaded';
            }
        ]);
    }

    protected function setupCreateOperation() {
        CRUD::setValidation(ResearchRepositoryRequest::class);

        CRUD::field('project_name');
        CRUD::field('members');
        CRUD::field('department')->type('select_from_array')->options([
            'Engineering' => 'Engineering',
            'Computer Science' => 'Computer Science',
            'Business' => 'Business',
            'Education' => 'Education',
            'Medicine' => 'Medicine',
        ]);
        CRUD::field('abstract')->type('textarea');

        // Upload Banner Image
        CRUD::field('banner_image')->type('upload')->upload(true)->disk('public');

        // Upload PDF File
        CRUD::field('file')->type('upload')->upload(true)->disk('public');

        CRUD::field('approved')->type('checkbox');
        
        // Add rejection fields
        CRUD::field('rejected')->type('checkbox');
        CRUD::field([
            'name' => 'rejection_reason',
            'type' => 'textarea',
            'label' => 'Rejection Reason',
            'wrapper' => [
                'class' => 'form-group rejection-reason-field',
            ],
        ]);
    }

    protected function setupUpdateOperation() {
        $this->setupCreateOperation();
    }
}
