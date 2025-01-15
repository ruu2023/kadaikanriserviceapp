<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
  public function index()
  {
    $content = Task::find(2)->content;
    return view("task", ["content" => $content]); // resources/views/task.blade.php
  }
}
