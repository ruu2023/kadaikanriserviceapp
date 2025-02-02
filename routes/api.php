<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/user', function (Request $request) {
  return $request->user();
})->middleware('auth:sanctum');


// タスクのルート
Route::resource('tasks', TaskController::class);

// アーカイブのルート
Route::get('archives', [TaskController::class, 'archive']);

// タスクの並び替えのルート
Route::post('/update-order', [TaskController::class, 'updateOrder']);

// タスクの完了
Route::post('/tasks/{task}/complete-task', [TaskController::class, 'completeTask']);
