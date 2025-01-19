<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
  use HasFactory;

  protected $fillable = ['content', 'user_id', 'row_order', 'updated_at']; // 更新可能なカラムを指定

  public static function createTask(array $data)
  {
    return self::create([
      'content' => $data['name'],
      'user_id' => $data['description'] ?? null,
      'row_order' => $data['due_date'] ?? null,
    ]);
  }
}
