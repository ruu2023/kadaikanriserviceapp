<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::table('tasks')->insert(
      [
        'user_id' => 2,
        'content' => 'Laravel',
        'row_order' => 1,
        'created_at' => "2024-12-09",
        'updated_at' => "2024-12-09"
      ],
      [
        'user_id' => 2,
        'content' => 'PHP',
        'row_order' => 2,
        'created_at' => "2024-12-09",
        'updated_at' => "2024-12-09"
      ],
      [
        'user_id' => 2,
        'content' => 'Ruby',
        'row_order' => 3,
        'created_at' => "2024-12-09",
        'updated_at' => "2024-12-09"
      ],
    );
  }
}
