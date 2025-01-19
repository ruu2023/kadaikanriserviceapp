<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
  public function dashboard()
  {
    $tasks = Task::all();
    return view("dashboard", compact('tasks'));
  }
  // public function store(Request $request)
  // {
  //   $data =  $request->all();
  //   Task::createTask($data);
  //   return redirect()->route('dashboard');
  // }
  public function index()
  {
    $tasks = Task::all();
    return response()->json($tasks);
  }
  public function store(Request $request)
  {
    $data = $request->validate([
      'content' => 'required|string|max:255',
    ]);

    $task = Task::createTask($data);

    // 作成したタスクをJSON形式で返す
    return response()->json($task);
  }
}
