@extends('layouts.app')

@section('title', 'ログイン')

@section('content')
  <section id="login">
    <h2 class="text-center mb-4">ログイン</h2>

    <form action="{{ route('login') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label class="block" for="email">メールアドレス</label>
        <input id="email" class="border border-slate-400 p-2 w-full rounded-md" name="email" type="email"
          value="{{ old('email') }}" autofocus autocomplete="email" required />
        @error('email')
          <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label class="block" for="password">パスワード</label>
        <input id="password" class="border border-slate-400 p-2 w-full rounded-md" name="password" type="password"
          autocomplete="current-password" required />
        @error('password')
          <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="flex justify-center items-center mb-3 form-check">
        <input id="remember"
          class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
          name="remember" type="checkbox" />
        <label class="ml-3" for="remember">ログイン情報を記憶する</label>
      </div>

      <div class="flex justify-center flex-row-reverse">
        <button
          class="block w-auto text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
          type="submit">ログイン</button>
        <a href="{{ route('home') }}"
          class="w-auto text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">戻る</a>
      </div>
    </form>
  </section><!-- /#login -->
@endsection
