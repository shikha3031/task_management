<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// Default route to redirect to the tasks index page when hitting the root URL
Route::get('/', [TaskController::class, 'index'])->name('home');

// Resource route for the TaskController
Route::resource('tasks', TaskController::class);

// Custom route for toggling task completion
Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggleComplete'])->name('tasks.toggleComplete');

// API routes for tasks
Route::get('/api/tasks', [TaskController::class, 'apiIndex'])->name('api.tasks.index');
Route::post('/api/tasks', [TaskController::class, 'store'])->name('api.tasks.store');
Route::put('/api/tasks/{id}', [TaskController::class, 'update'])->name('api.tasks.update');
Route::delete('/api/tasks/{id}', [TaskController::class, 'destroy'])->name('api.tasks.destroy');
