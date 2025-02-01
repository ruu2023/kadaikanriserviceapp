<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Task Page</title>
  @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>
<body>
  <h2 class="text-center mb-4">ダッシュボード</h2>
  <p class="text-center">ログイン中: {{ Auth::user()->name }}</p>
  <div class="d-flex justify-content-center">
      <a href="{{ route('home') }}" class="btn btn-outline-secondary mx-2">トップページに戻る</a>
  </div>
  <form class="text-center mt-4" action="{{ route('logout') }}" method="POST" class="d-inline">
      @csrf
      <button type="submit" class="btn btn-danger mx-2">ログアウト</button>
  </form>
  <div id="app"></div>
  <!-- ユーザーデータをグローバルに公開 -->
  <script>
    window.Laravel = {
      user: @json(Auth::user())
    }
  </script>
</body>
</html>
