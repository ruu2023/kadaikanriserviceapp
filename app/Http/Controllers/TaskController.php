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
    $tasks = Task::orderBy('row_order', 'asc')->get();
    return response()->json($tasks);
  }
  public function store(Request $request)
  {
    $data = $request->validate([
      'content' => 'required|string|max:140',
    ]);
    $data['content'] = strip_tags($data['content']); // XSS 対策 空が登録されても可

    $task = Task::createTask($data);

    // 作成したタスクをJSON形式で返す
    return response()->json($task);
  }
  public function update(Request $request, Task $task)
  {
    // バリデーション
    $request->validate([
      'content' => 'required|string|max:140',
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
  public function updateOrder(Request $request)
  {
    // バリデーション
    $validated = $request->validate([
      'tasks' => 'required|array',
      'tasks.*.id' => 'required|integer|exists:tasks,id',
      'tasks.*.row_order' => 'required|integer',
    ]);

    try {
      foreach ($validated['tasks'] as $taskData) {
        // 各タスクの order を更新
        Task::where('id', $taskData['id'])
          ->update(['row_order' => $taskData['row_order']]);
      }

      return response()->json(['message' => 'Order updated successfully'], 200);
    } catch (\Exception $e) {
      // エラー時のレスポンス
      return response()->json(['message' => 'Error updating order', 'error' => $e->getMessage()], 500);
    }
  }
}
