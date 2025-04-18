<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResearchRepositoryController;
use App\Http\Controllers\FacultyResearchController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\DissertationController;
use App\Http\Controllers\HistoryController;

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

    // Upload selection page
    Route::get('/upload-select', function () {
        return view('upload_select');
    })->name('upload.select');

    // Upload routes
    Route::get('/upload', function () {
        return view('upload');
    })->name('upload');

    // Dissertation upload routes
    Route::get('/upload/dissertation', [DissertationController::class, 'create'])
        ->name('upload.dissertation');
    Route::post('/dissertation/store', [DissertationController::class, 'store'])
        ->name('dissertation.store');
    Route::get('/dissertation/history', [DissertationController::class, 'history'])
        ->name('dissertation.history');
    Route::get('/dissertation/{id}', [DissertationController::class, 'show'])
        ->name('dissertation.show');
    Route::post('/dissertation/{id}/download', [DissertationController::class, 'download'])
        ->name('dissertation.download');

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

    // Shared history view showing all submissions
    Route::get('/history', [HistoryController::class, 'index'])->name('history');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/research', [ResearchRepositoryController::class, 'adminIndex'])
        ->name('admin.research.index');
    Route::put('/research/{id}/status', [ResearchRepositoryController::class, 'updateStatus'])
        ->name('research.status.update');
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

Route::get('/search-recommendations', [App\Http\Controllers\ResearchRepositoryController::class, 'getSearchRecommendations'])->name('search.recommendations');

// Department Routes
Route::get('/department/{department}', [DepartmentController::class, 'show'])->name('department.show');
Route::get('/departments/{department}', [DepartmentController::class, 'show'])->name('department.show');

// Research Routes
Route::get('/research/{id}', [ResearchController::class, 'show'])->name('research.show');
Route::post('/research/{id}/download', [ResearchController::class, 'download'])->name('research.download');
Route::post('/research/{project}/download', [ResearchController::class, 'download'])->name('research.download');
Route::get('/check-research/{name}', function($name) {
    return response()->json([
        'exists' => \App\Models\Research::where('project_name', $name)->exists()
    ]);
});
Route::get('department/{department}', [DepartmentController::class, 'show'])->name('department.show');

// Add this to your web.php routes file
Route::get('/dissertations', [App\Http\Controllers\DissertationController::class, 'index'])
    ->name('dissertation.index');

// Add this to your routes/web.php file
Route::get('/research', [ResearchRepositoryController::class, 'index'])->name('research.index');

require __DIR__.'/auth.php';
