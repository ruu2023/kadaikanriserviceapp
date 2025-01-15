@extends('layouts.app')

@section('title', 'ユーザー登録')

@section('content')
  <h2 class="text-center mb-4">ユーザー登録</h2>
  <form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="mb-3">
      <label for="name" class="form-label">ユーザー名</label>
      @error('name')
        <div class="text-danger">{{ $message }}</div>
      @enderror
      <input id="name" type="text" name="name" class="border border-slate-400 p-2 w-full rounded-md"
        value="{{ old('name') }}" autofocus>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">メールアドレス</label>
      @error('email')
        <div class="text-danger">{{ $message }}</div>
      @enderror
      <input id="email" type="email" name="email" class="border border-slate-400 p-2 w-full rounded-md"
        value="{{ old('email') }}">
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">パスワード</label>
      @error('password')
        <div class="text-danger">{{ $message }}</div>
      @enderror
      <input id="password" type="password" name="password" class="border border-slate-400 p-2 w-full rounded-md">
    </div>

    <div class="mb-3">
      <label for="password-confirm" class="form-label">パスワード確認</label>
      @error('password_confirmation')
        <div class="text-danger">{{ $message }}</div>
      @enderror
      <input id="password-confirm" type="password" name="password_confirmation"
        class="border border-slate-400 p-2 w-full rounded-md">
    </div>
    <div class="flex justify-center flex-row-reverse">
      <button type="submit"
        class="block w-auto text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">登録</button>
      <a href="{{ route('home') }}"
        class="w-auto text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">戻る</a>
    </div>
  </form>

@endsection
