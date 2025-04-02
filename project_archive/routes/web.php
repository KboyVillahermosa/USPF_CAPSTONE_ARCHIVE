<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResearchRepositoryController;


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
});



// Upload form view
Route::get('/upload', function () {
    return view('upload');
})->name('upload');


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
