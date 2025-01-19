<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
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

  // public function dashboard()
  // {
  //   $tasks = Task::all();
  //   return view('dashboard', compact('tasks'));
  // }
}
