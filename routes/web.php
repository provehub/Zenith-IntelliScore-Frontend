<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', [MainController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('user/dashboard', [MainController::class, 'userDashboard'])->middleware(['auth', 'verified'])->name('user.dashboard');

require __DIR__.'/settings.php';
