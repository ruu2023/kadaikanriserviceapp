<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskService
{
  public function completeTask()
  {
    return Task::all();
  }
  public function store(Request $request)
  {
    // バリデーション
    $validatedData = $request->validate([
      'content' => 'required|string|max:255',
    ]);

    // タスクを作成
    $task = Task::createTask($validatedData);

    return redirect()->route('tasks.index')->with('success', 'タスクを作成しました!');
  }
}
