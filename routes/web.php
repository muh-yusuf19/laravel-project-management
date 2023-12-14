<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {

    // Admin
    Route::middleware('is_admin')->group(function() {
        // Project
        Route::get('/project', [ProjectController::class, 'index'])->name('project.index');
        Route::get('/project/create', [ProjectController::class, 'create'])->name('project.create');
        Route::post('/project/store', [ProjectController::class, 'store'])->name('project.store');
        Route::put('/project/{project}/edit', [ProjectController::class, 'edit'])->name('project.edit');
        Route::patch('/project/update/{project}', [ProjectController::class, 'update'])->name('project.update');
        Route::delete('/project/delete/{project}', [ProjectController::class, 'destroy'])->name('project.delete');

        // Task
        Route::get('/task', [TaskController::class, 'index'])->name('task.index');
        Route::get('/task/create', [TaskController::class, 'create'])->name('task.create');
        Route::post('/task/store', [TaskController::class, 'store'])->name('task.store');
        Route::get('/task/{task}/edit', [TaskController::class, 'edit'])->name('task.edit');
        Route::patch('/task/update/{task}', [TaskController::class, 'update'])->name('task.update');
    });

    // User
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/detail-project/{project}', [DashboardController::class, 'detail'])->name('detail-project');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
