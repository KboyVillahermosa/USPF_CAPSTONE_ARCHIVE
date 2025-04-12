<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Http\Requests\UserRequest;
use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Illuminate\Support\Facades\DB;

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
        
        // Call the batch import setup
        $this->setupBatchImportOperation();

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

    /**
     * Define what happens when the Batch Import operation is loaded.
     * 
     * @return void
     */
    protected function setupBatchImportOperation()
    {
        // Add a button for batch import in the top of the list view
        $this->crud->operation('batchImport', function () {
            $this->crud->loadDefaultOperationSettingsFromConfig();
        });
        
        $this->crud->operation(['list'], function () {
            // Add a button in the top of the list view
            $this->crud->addButton('top', 'batch_import', 'view', 'vendor.backpack.crud.buttons.batch_import');
        });
    }

    /**
     * Show the batch import form
     */
    public function batchImportForm()
    {
        $this->data['crud'] = $this->crud;
        $this->data['title'] = CRUD::getTitle() ?? 'Batch Import Users';
        
        return view('admin.users.batch_import', $this->data);
    }

    /**
     * Process the CSV import
     */
    public function batchImport()
    {
        $request = request();
        
        // Validate the uploaded file
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:10000',
        ]);
        
        // Get the file
        $file = $request->file('csv_file');
        
        // Process the CSV
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));
        
        // Get headers
        $headers = array_shift($data);
        
        // Required fields
        $requiredFields = ['name', 'email', 'role', 'department'];
        
        // Validate headers
        foreach ($requiredFields as $field) {
            if (!in_array($field, $headers)) {
                \Alert::error("Missing required column: $field")->flash();
                return redirect()->back();
            }
        }
        
        // Count for stats
        $created = 0;
        $errors = 0;
        $error_messages = [];
        
        // Process each row
        foreach ($data as $row) {
            $user_data = array_combine($headers, $row);
            
            // Generate a random password if not provided
            if (!isset($user_data['password']) || empty($user_data['password'])) {
                $user_data['password'] = \Illuminate\Support\Str::random(10);
            }
            
            // Hash password
            $user_data['password'] = \Hash::make($user_data['password']);
            
            try {
                // Create the user
                \App\Models\User::create($user_data);
                $created++;
            } catch (\Exception $e) {
                $errors++;
                $error_messages[] = "Row " . ($created + $errors) . ": " . $e->getMessage();
            }
        }
        
        // Flash appropriate message
        if ($created > 0) {
            \Alert::success("Successfully created $created users.")->flash();
        }
        
        if ($errors > 0) {
            \Alert::error("Failed to create $errors users. Check the details below.")->flash();
            foreach ($error_messages as $message) {
                \Alert::error($message)->flash();
            }
        }
        
        return redirect(backpack_url('user'));
    }

    public function destroy($id)
    {
        // Begin a transaction
        DB::beginTransaction();
        
        try {
            // First delete related dissertations
            DB::table('dissertations')->where('user_id', $id)->delete();
            
            // If you have other related tables, delete from those too
            // DB::table('other_table')->where('user_id', $id)->delete();
            
            // Then delete the user
            $this->crud->delete($id);
            
            DB::commit();
            
            return $this->crud->performDeleteResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to delete user: ' . $e->getMessage()
            ], 500);
        }
    }
}
