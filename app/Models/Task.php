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
    $rowOrder = self::min('row_order') - 1;
    return self::create([
      'content' => $data['content'],
      'user_id' => $data['user_id'],
      'row_order' => $rowOrder,
    ]);
  }
}
