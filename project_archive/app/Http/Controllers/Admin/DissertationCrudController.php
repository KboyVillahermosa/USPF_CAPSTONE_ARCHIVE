<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DissertationRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class DissertationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Dissertation::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/dissertation');
        CRUD::setEntityNameStrings('dissertation', 'dissertations');
        
        // Only show entries with type 'dissertation'
        $this->crud->addClause('where', 'type', 'dissertation');
    }

    protected function setupListOperation()
    {
        CRUD::column('id');
        CRUD::column('created_at')->label('Submission Date');
        CRUD::column('title');
        CRUD::column('author');
        CRUD::column('department');
        CRUD::column('year');
        
        // Status column with color coding
        CRUD::addColumn([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'closure',
            'function' => function($entry) {
                if ($entry->status == 'approved') {
                    return '<span class="badge badge-success">Approved</span>';
                } elseif ($entry->status == 'rejected') {
                    return '<span class="badge badge-danger">Rejected</span>';
                } else {
                    return '<span class="badge badge-warning">Pending</span>';
                }
            }
        ]);
        
        // Abstract preview (shortened)
        CRUD::addColumn([
            'name' => 'abstract',
            'label' => 'Abstract',
            'type' => 'closure',
            'function' => function($entry) {
                $plainText = strip_tags($entry->abstract);
                return strlen($plainText) > 100 ? substr($plainText, 0, 100) . '...' : $plainText;
            }
        ]);
        
        // Keywords
        CRUD::column('keywords');
        
        // Clickable file link
        CRUD::addColumn([
            'name' => 'file_path',
            'label' => 'File',
            'type' => 'closure',
            'function' => function($entry) {
                if ($entry->file_path) {
                    return '<a href="'.asset('storage/'.$entry->file_path).'" target="_blank" class="btn btn-sm btn-link"><i class="la la-download"></i> Download</a>';
                }
                return 'No file uploaded';
            }
        ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(DissertationRequest::class);

        CRUD::field('title');
        CRUD::field('author');
        CRUD::field('type')->type('hidden')->value('dissertation'); // Set type automatically
        CRUD::field('department')->type('select_from_array')->options([
            'College of Engineering and Architecture' => 'College of Engineering and Architecture',
            'College of Computer Studies' => 'College of Computer Studies',
            'College of Health Sciences' => 'College of Health Sciences',
            'College of Social Work' => 'College of Social Work',
            'College of Teacher Education, Arts and Sciences' => 'College of Teacher Education, Arts and Sciences',
            'School of Business and Accountancy' => 'School of Business and Accountancy',
            'Graduate School' => 'Graduate School',
        ]);
        CRUD::field('year')->type('number')->attributes(['min' => 1900, 'max' => date('Y') + 1]);
        
        // Use regular textarea instead of wysiwyg
        CRUD::field([
            'name' => 'abstract',
            'type' => 'textarea',
            'label' => 'Abstract',
            'attributes' => [
                'rows' => 5
            ]
        ]);
        
        CRUD::field('keywords');
        
        // Upload Document File
        CRUD::field('file_path')->type('upload')->upload(true)->disk('public')->label('Document File (PDF/DOC)');
        
        // Add status field
        CRUD::field([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'select_from_array',
            'options' => [
                'pending' => 'Pending',
                'approved' => 'Approved',
                'rejected' => 'Rejected'
            ],
            'default' => 'pending',
        ]);
        
        // Add rejection reason field with special class for JS targeting
        CRUD::field([
            'name' => 'rejection_reason',
            'type' => 'textarea',
            'label' => 'Rejection Reason',
            'hint' => 'Required if status is rejected',
            'wrapper' => [
                'class' => 'form-group rejection-reason-field',
            ],
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
    
    protected function setupShowOperation()
    {
        $this->setupListOperation();
        
        // Add the rejection reason if it exists
        CRUD::column('rejection_reason');
        
        // Add the user who uploaded it
        CRUD::addColumn([
            'name' => 'user_id',
            'label' => 'Submitted By',
            'type' => 'relationship',
            'entity' => 'user',
            'attribute' => 'name',
        ]);
        
        // Show document preview for PDFs
        CRUD::addColumn([
            'name' => 'document_preview',
            'label' => 'Document Preview',
            'type' => 'closure',
            'function' => function($entry) {
                if ($entry->file_path && strtolower(pathinfo($entry->file_path, PATHINFO_EXTENSION)) === 'pdf') {
                    return '<div class="pdf-preview">
                                <iframe src="'.asset('storage/'.$entry->file_path).'" width="100%" height="500px"></iframe>
                            </div>';
                }
                return 'Preview not available for this file type.';
            }
        ]);
    }
}
