<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
  public function login(Request $request)
  {
    // バリデーション
    $request->validate([
      'email' => 'required|email',
      'password' => 'required|string|min:8',
    ]);

    // 認証
    if (!Auth::attempt(['email' => $request->email, 'password' => $request->password], false)) {
      return response()->json([
        'success' => false,
        'message' => 'Unauthorized'
      ], 401);
    }

    // 認証成功
    $user = Auth::user();
    if (!$user) {
      return response()->json([
        'success' => false,
        'message' => '認証に失敗しました'
      ], 401);
    }

    // トークン発行（適切な権限を設定）
    $token = $user->createToken('YourAppName', ['access:user'])->plainTextToken;

    return response()->json([
      'success' => true,
      'message' => 'ログイン成功',
      'user' => $user,
      'token' => $token
    ]);
  }
}
