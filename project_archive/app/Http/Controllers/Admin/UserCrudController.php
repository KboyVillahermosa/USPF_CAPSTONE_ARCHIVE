<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Http\Requests\UserRequest;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');

        // Email field
        $this->crud->addField([
            'name' => 'email',
            'type' => 'email',
            'label' => 'Email',
            'attributes' => [
                'required' => 'required'
            ],
        ]);

        // Name field
        $this->crud->addField([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Full Name',
            'attributes' => [
                'required' => 'required'
            ],
        ]);

        // Department field
        $this->crud->addField([
            'name' => 'department',
            'type' => 'select_from_array',
            'options' => [
                'CCS' => 'College of Computer Studies',
                'COE' => 'College of Engineering',
                'CBA' => 'College of Business Administration',
                // Add other departments
            ],
            'label' => 'Department',
            'allows_null' => false,
        ]);

        // Course field
        $this->crud->addField([
            'name' => 'course',
            'type' => 'select_from_array',
            'options' => [
                'BSIT' => 'BS Information Technology',
                'BSCS' => 'BS Computer Science',
                'BSIS' => 'BS Information Systems',
                // Add other courses
            ],
            'label' => 'Course',
        ]);

        // Year Level field
        $this->crud->addField([
            'name' => 'year_level',
            'type' => 'select_from_array',
            'options' => [
                '1st' => '1st Year',
                '2nd' => '2nd Year',
                '3rd' => '3rd Year',
                '4th' => '4th Year',
            ],
            'label' => 'Year Level',
        ]);

        // Student ID field
        $this->crud->addField([
            'name' => 'student_id',
            'type' => 'text',
            'label' => 'Student/Faculty ID',
        ]);

        // Role field
        $this->crud->addField([
            'name' => 'role',
            'type' => 'select_from_array',
            'options' => [
                'student' => 'Student',
                'faculty' => 'Faculty',
                'admin' => 'Administrator'
            ],
            'label' => 'Role',
            'allows_null' => false,
        ]);

        // Position field (for faculty)
        $this->crud->addField([
            'name' => 'position',
            'type' => 'text',
            'label' => 'Position',
        ]);

        // Password field
        $this->crud->addField([
            'name' => 'password',
            'type' => 'password',
            'label' => 'Password',
        ]);
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // set columns from db columns.

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
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
        CRUD::setValidation(UserRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
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
    }

    public function store()
    {
        try {
            $response = $this->traitStore();
            \Alert::success('User created successfully')->flash();
            return $response;
        } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
            \Alert::error('The email address is already in use.')->flash();
            return redirect()->back()->withInput();
        }
    }
}
