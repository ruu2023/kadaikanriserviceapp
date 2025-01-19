<?php

namespace App\Services;

use App\Models\Task;

class TaskService
{
  public function getAllTasks()
  {
    return Task::all();
  }
  // 変更点
}
