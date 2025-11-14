<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Admin\{AdminController,SettingsController};
use App\Http\Controllers\{MainController,ProjectController,LivenessController,StatementController};

Route::get('/', [MainController::class, 'index'])->name('index');

Route::get('dashboard', [MainController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('user/dashboard', [MainController::class, 'userDashboard'])->middleware(['auth', 'verified'])->name('user.dashboard');

// tests
Route::get('tester', [ProjectController::class, 'tester']);

Route::get('/verify/live/{vendor}/{extras}', [LivenessController::class, 'index'])->name('live.index');

Route::get('/view/liveness/{vendor}/{extras}', [LivenessController::class, 'show'])->name('liveness.show');

Route::post('/liveness', [LivenessController::class, 'store'])->name('create.liveness');

Route::post('upload/bank/data', [StatementController::class, 'upload'])->name('upload.bank');
// accounts
Route::group(['prefix' => 'project', 'middleware' => ['auth']], function() {
    Route::get('upload/data', [ProjectController::class, 'uploadData'])->name('upload.data');
    
    Route::post('store/new/project', [ProjectController::class, 'store'])->name('project.store');
    Route::post('process/new/verification', [ProjectController::class, 'verify'])->name('project.verify');

    Route::post('process/pin/verification', [ProjectController::class, 'verifyPhone'])->name('pin.verify');
});

// admin

Route::group(['prefix' => 'admin', 'middleware' => ['auth',]], function() {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('all/accounts', [AdminController::class, 'agents'])->name('admin.agents');
});

// miscs
Route::get('/storage-link', function() {
    Artisan::call('storage:link');
    return "Symlinked";
});

Route::get('/optimize-clear', function() {
    Artisan::call('optimize:clear');
    return "All cleared";
});



Route::get('/404', [MainController::class, 'fourofour'])->name('fourofour');

Route::fallback(function () {
    return Redirect::route('fourofour');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
