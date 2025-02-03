<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Sanctum\Http\Middleware\CheckAbilities;
use Laravel\Sanctum\Http\Middleware\CheckForAnyAbility;
use Illuminate\Http\Middleware\HandleCors;

return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    web: __DIR__ . '/../routes/web.php',
    api: __DIR__ . '/../routes/api.php',
    commands: __DIR__ . '/../routes/console.php',
    health: '/up',
  )
  ->withMiddleware(function (Middleware $middleware) {
    $middleware->append(HandleCors::class); // CORS ミドルウェアを適用
    $middleware->alias([
      'abilities' => CheckAbilities::class,
      'ability' => CheckForAnyAbility::class,
      // 他のミドルウェア
    ]);
  })
  ->withExceptions(function (Exceptions $exceptions) {
    //
  })->create();
