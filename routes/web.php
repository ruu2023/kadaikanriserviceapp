<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any}', function () {
  return view('app'); // Vue のエントリーポイント (resources/views/app.blade.php)
})->where('any', '.*'); // すべてのルートをキャッチ
