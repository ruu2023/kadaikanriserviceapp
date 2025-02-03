<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function logout(Request $request)
  {
    // 現在のユーザーのトークンを無効化
    $request->user()->currentAccessToken()->delete();

    return response()->json(['message' => 'Successfully logged out']);
  }
}
