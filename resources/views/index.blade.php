@extends('layouts.app')

@section('title', 'ページタイトル')

@section('content')
  <section id="top-page">
    <h2 class="text-center mb-4">Welcome</h2>

    <div class="mb-8">
      <ul>
        <li>アプリの説明</li>
      </ul>
    </div>

    @auth
      <p class="text-center mb-8">ログイン中: {{ Auth::user()->name }}</p>
    @endauth

    <div class="flex justify-center">
      @auth
        <a href="{{ route('dashboard') }}"
          class="block w-auto text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">ダッシュボード</a>
      @else
        <a href="{{ route('register') }}"
          class="block w-auto text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">ユーザー登録</a>
        <a href="{{ route('login') }}"
          class="block w-auto text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">ログイン</a>
      @endauth
    </div>
  </section><!-- /#top-page -->
@endsection
