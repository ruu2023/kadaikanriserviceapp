<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

// ユーザー認証
Route::post("register", [RegisterController::class, "register"]);
Route::post("login", [LoginController::class, "login"]);

Route::middleware('auth:sanctum')->group(function () {
  Route::get('user', [AuthController::class, 'user']);
  Route::post('logout', [AuthController::class, 'logout']);
  Route::get('dashboard', function (Request $request) {
    return response()->json(["message" => "Welcome to your dashboard, " . $request->user()->name]);
  });
  // 🔥 すべてのタスクのルートに認証を適用
  Route::resource('tasks', TaskController::class);
  // アーカイブのルート
  Route::get('archives', [TaskController::class, 'archive']);
  // 全てのタスクの削除
  Route::delete('tasks-delete', [TaskController::class, 'deleteAllTasks']);
  // タスクの完了
  Route::post('tasks/{task}/complete-task', [TaskController::class, 'completeTask']);
  // アーカイブされた全てのタスクの削除
  Route::delete('archives-delete', [TaskController::class, 'deleteAllArchive']);
  // タスクの並び替えのルート
  Route::post('update-order', [TaskController::class, 'updateOrder']);
});
