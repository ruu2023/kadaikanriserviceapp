<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Archive;
use Illuminate\Support\Facades\Auth;

class TaskService
{
  public function getAllTasks()
  {
    return Task::all();
  }

  public function getOrderedTasks()
  {
    return Task::orderBy('row_order', 'asc')->get();
  }

  public function store(Request $request)
  {
    // バリデーション
    $validatedData = $request->validate([
      'content' => 'required|string|max:255',
    ]);

    $validatedData['user_id'] = Auth::id();

    // タスクを作成
    $task = Task::createTask($validatedData);

    return response()->json($task, 201);
  }

  public function update(Request $request, Task $task)
  {
    // バリデーション
    $validatedData = $request->validate([
      'content' => 'required|string|max:140',
    ]);

    // タスクの更新
    $task->update([
      'content' => $validatedData['content'],
    ]);

    return $task;
  }

  public function destroy($id)
  {
    $task = Task::findOrFail($id);
    $task->delete();

    return true;
  }

  public function deleteAllTasks()
  {
    Task::truncate();
    return true;
  }

  public function deleteAllArchive()
  {
    Archive::truncate();
    return true;
  }

  public function updateOrder(array $tasksData)
  {
    foreach ($tasksData as $taskData) {
      Task::where('id', $taskData['id'])
        ->update(['row_order' => $taskData['row_order']]);
    }

    return true;
  }

  public function completeTask(Task $task)
  {
    $data['content'] = $task->content;
    $data['user_id'] = Auth::id();

    Archive::createArchive($data);

    // 元のタスクを削除
    $task->delete();

    return true;
  }

  public function getArchives()
  {
    return Archive::orderBy('row_order', 'asc')->get();
  }
}
