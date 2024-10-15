<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// Define API routes for tasks
Route::get('/tasks', [TaskController::class, 'apiIndex'])->name('api.tasks.index');
Route::post('/tasks', [TaskController::class, 'store'])->name('api.tasks.store');
Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('api.tasks.update');
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('api.tasks.destroy');
