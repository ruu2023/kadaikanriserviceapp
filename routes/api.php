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
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::post('/tokens/create', function (Request $request) {
  $token = $request->user()->createToken($request->token_name);

  return ['token' => $token->plainTextToken];
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return response()->json($request->user());
});

Route::middleware("auth:sanctum")->get("dashboard", function (Request $request) {
  return response()->json(["message" => "Welcome to your dashboard, " . $request->user()->name]);
});

// タスクのルート
Route::resource('tasks', TaskController::class);

// アーカイブのルート
Route::get('archives', [TaskController::class, 'archive']);

// タスクの並び替えのルート
Route::post('/update-order', [TaskController::class, 'updateOrder']);

// タスクの完了
Route::post('/tasks/{task}/complete-task', [TaskController::class, 'completeTask']);
