<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Services\TaskService;

class TaskController extends Controller
{
  protected $taskService;

  public function __construct(TaskService $taskService)
  {
    $this->taskService = $taskService;
  }

  public function dashboard()
  {
    $tasks = $this->taskService->getAllTasks();
    return view("dashboard", compact('tasks'));
  }

  public function index()
  {
    $tasks = $this->taskService->getOrderedTasks();
    return response()->json($tasks);
  }

  public function store(Request $request)
  {
    return $this->taskService->store($request);
  }

  public function update(Request $request, Task $task)
  {
    try {
      $updatedTask = $this->taskService->update($request, $task);

      return response()->json([
        'message' => 'Task updated successfully',
        'content' => $updatedTask->content
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
    $this->taskService->destroy($id);
    return response()->json(['message' => 'タスク削除成功'], 200);
  }

  public function deleteAllTasks()
  {
    $this->taskService->deleteAllTasks();
    return response()->json(['message' => '全てのタスクを削除しました'], 200);
  }

  public function deleteAllArchive()
  {
    $this->taskService->deleteAllArchive();
    return response()->json(['message' => '全てのアーカイブを削除しました'], 200);
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
      $this->taskService->updateOrder($validated['tasks']);
      return response()->json(['message' => 'Order updated successfully'], 200);
    } catch (\Exception $e) {
      // エラー時のレスポンス
      return response()->json(['message' => 'Error updating order', 'error' => $e->getMessage()], 500);
    }
  }

  public function completeTask(Task $task)
  {
    try {
      $this->taskService->completeTask($task);

      return response()->json([
        'message' => 'Task archived successfully'
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'Failed to archive task',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function archive()
  {
    $archives = $this->taskService->getArchives();
    return response()->json($archives);
  }
}
