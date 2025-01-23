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
  public function update(Request $request, Task $task)
  {
    // バリデーション
    $request->validate([
      'content' => 'required|string|max:255',
    ]);

    try {
      // タスクの更新
      $task->update([
        'content' => $request->content,
      ]);

      // 更新されたタスクを返す
      return response()->json([
        'message' => 'Task updated successfully',
        'content' => $task->content
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'Failed to update task',
        'error' => $e->getMessage()
      ], 500);
    }
  }
  public function destroy($id)
  {
    $task = Task::findOrFail($id);
    $task->delete();

    return response()->json(['message' => 'タスク削除成功'], 200);
  }
}
