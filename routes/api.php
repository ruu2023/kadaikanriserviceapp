<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/tasks', [TaskController::class, 'indexApi']);
Route::post('/tasks', [TaskController::class, 'storeApi']);
