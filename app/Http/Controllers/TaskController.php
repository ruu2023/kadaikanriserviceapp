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
  public function store(Request $request)
  {
    $data =  $request->all();
    Task::createTask($data);
    return redirect()->route('dashboard');
  }
}
