<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register')
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/tasks', [TaskController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('tasks');

Route::get('/tasks/create', [TaskController::class, 'create'])
    ->middleware(['auth', 'verified'])->name('/tasks/create');

Route::post('/tasks/store', [TaskController::class, 'store'])
    ->middleware(['auth', 'verified'])->name('tasks.store');

Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])
    ->middleware(['auth', 'verified'])->name('tasks.destroy');

Route::patch('/tasks/{id}', [TaskController::class, 'update'])
    ->middleware(['auth', 'verified'])
    ->name('tasks.update');

Route::patch('/tasks/{id}/category', [TaskController::class, 'categoryUpdate'])
    ->middleware(['auth', 'verified'])
    ->name('tasks.category');


Route::get('/categories', [CategoryController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('categories');


Route::get('/categories/create', [CategoryController::class, 'create'])
    ->middleware(['auth', 'verified'])->name('/categories/create');

Route::post('/categories/store', [CategoryController::class, 'store'])
    ->middleware(['auth', 'verified'])->name('categories.store');

Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])
    ->middleware(['auth', 'verified'])->name('categories.destroy');

Route::patch('/categories/{id}', [CategoryController::class, 'update'])
    ->middleware(['auth', 'verified'])
    ->name('categories.update');




Route::get('/settings', function () {
    return Inertia::render('Setting');
})->middleware(['auth', 'verified'])->name('settings');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
