<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

// トップページのルート
Route::get('/', [HomeController::class, 'index'])->name('home');

// ダッシュボードのルート（ログインが必要）
Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware('auth')->name('dashboard');

// ユーザー登録のルート
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
Route::post('register', [RegisterController::class, 'register']);

// ログインのルート
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);

// ログアウトのルート
Route::post('logout', [LogoutController::class, 'logout'])->name('logout');

Route::resource('tasks', TaskController::class);
