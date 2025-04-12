<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\CRUD.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('user', 'UserCrudController');
    Route::crud('research-repository', 'ResearchRepositoryCrudController');
    Route::crud('dissertation', 'DissertationCrudController');
    Route::crud('thesis', 'ThesisCrudController');

    // Dissertation approval/rejection routes
    Route::get('dissertation/{id}/approve', 'DissertationCrudController@approve');
    Route::get('dissertation/{id}/reject', 'DissertationCrudController@rejectForm');
    Route::post('dissertation/{id}/reject', 'DissertationCrudController@rejectSubmit');
    
    // Thesis approval/rejection routes
    Route::get('thesis/{id}/approve', 'ThesisCrudController@approve');
    Route::get('thesis/{id}/reject', 'ThesisCrudController@rejectForm');
    Route::post('thesis/{id}/reject', 'ThesisCrudController@rejectSubmit');

    // Batch import users
    Route::get('user/batch-import', [App\Http\Controllers\Admin\UserCrudController::class, 'batchImportForm'])->name('user.batch.import.form');
    Route::post('user/batch-import', [App\Http\Controllers\Admin\UserCrudController::class, 'batchImport'])->name('user.batch.import');
}); // this should be the absolute last line of this file

/**
 * DO NOT ADD ANYTHING HERE.
 */
