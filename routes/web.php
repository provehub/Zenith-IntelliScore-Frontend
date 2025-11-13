<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Admin\{AdminController,SettingsController};
use App\Http\Controllers\{MainController,ProjectController};

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('index');

Route::get('dashboard', [MainController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('user/dashboard', [MainController::class, 'userDashboard'])->middleware(['auth', 'verified'])->name('user.dashboard');

// tests
Route::get('tester', [ProjectController::class, 'tester']);

// accounts
Route::group(['prefix' => 'project', 'middleware' => ['auth']], function() {
    Route::post('store/new/project', [ProjectController::class, 'store'])->name('project.store');
    Route::post('process/new/verification', [ProjectController::class, 'verify'])->name('project.verify');
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
