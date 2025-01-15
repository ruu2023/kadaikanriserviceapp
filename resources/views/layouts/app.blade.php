<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Laravel App')</title>
  @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>

<body  id="app">
  <header class="relative flex justify-between bg-white shadow-lg p-6">
      <h2 class="text-center">ページタイトル</h2>
      @auth
        <p class="text-center">ログイン中: {{ Auth::user()->name }}</p>
      @endauth
  </header>
  <main class="flex flex-col items-center justify-center min-h-screen bg-slate-200 py-3">
    <div class="container shadow-md bg-white py-3 px-3 md:px-10">
      @yield('content')
    </div>
  </main>
</body>

</html>
