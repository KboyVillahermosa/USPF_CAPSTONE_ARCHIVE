<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResearchRepositoryController;
use App\Http\Controllers\FacultyResearchController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/upload/faculty', [FacultyResearchController::class, 'create'])->name('upload.faculty');
    Route::post('/research/faculty', [FacultyResearchController::class, 'store'])->name('research.faculty.store');
    Route::get('/research/history', [FacultyResearchController::class, 'history'])->name('research.history');

    // Upload routes
    Route::get('/upload', function () {
        return view('upload');
    })->name('upload');

    // Faculty Research Routes
    Route::get('/faculty/research/history', [FacultyResearchController::class, 'history'])
        ->name('research.history');
    Route::get('/faculty/research/{id}', [FacultyResearchController::class, 'show'])
        ->name('faculty.research.show');
    Route::get('/faculty/research/{id}/edit', [FacultyResearchController::class, 'edit'])
        ->name('faculty.research.edit');
    Route::put('/faculty/research/{id}', [FacultyResearchController::class, 'update'])
        ->name('faculty.research.update');

    Route::get('/research/{id}', [FacultyResearchController::class, 'show'])->name('research.show');
});


// Store uploaded research
Route::post('/research/store', [ResearchRepositoryController::class, 'store'])->name('research.store');

// Dashboard to display approved research projects
Route::get('/dashboard', [ResearchRepositoryController::class, 'dashboard'])->name('dashboard');


Route::get('/research/history', [ResearchRepositoryController::class, 'history'])->name('research.history');
Route::get('/research/edit/{id}', [ResearchRepositoryController::class, 'edit'])->name('research.edit');
Route::post('/research/update/{id}', [ResearchRepositoryController::class, 'update'])->name('research.update');






Route::get('/research/{id}', [ResearchRepositoryController::class, 'show'])->name('research.show');
Route::get('/research/edit/{id}', [ResearchRepositoryController::class, 'edit'])->name('research.edit');
Route::post('/research/update/{id}', [ResearchRepositoryController::class, 'update'])->name('research.update');
Route::put('/research/update/{id}', [ResearchRepositoryController::class, 'update'])->name('research.update');
Route::get('/history', [ResearchRepositoryController::class, 'history'])->name('history');

Route::get('/dashboard', [ResearchRepositoryController::class, 'dashboard'])->name('dashboard');


require __DIR__.'/auth.php';
