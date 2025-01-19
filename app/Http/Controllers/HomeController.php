<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\TaskService;

class HomeController extends Controller
{
  protected $taskService;

  public function __construct(TaskService $taskService)
  {
    $this->taskService = $taskService;
  }

  public function index()
  {
    return view('index');
  }

  public function dashboard()
  {
    $tasks = $this->taskService->getAllTasks();
    dd($tasks);
    return view('dashboard', compact('tasks'));
  }

  // 引数に文字を受け取ったら変更しました
}
