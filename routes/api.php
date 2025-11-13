<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ProjectController};

Route::get('/load/plans', [ProjectController::class, 'loadPlans'])->name('load.plans');
Route::middleware('web')->get('/set/current/project/{project}', [ProjectController::class, 'setCurrentProject'])->name('set.current.project');