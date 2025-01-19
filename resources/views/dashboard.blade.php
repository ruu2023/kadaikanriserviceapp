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


  {{-- タスクをループ表示 --}}
  @if ($tasks->isNotEmpty())
    @foreach ($tasks as $task)
      <p>{{ $task->content }}</p>
      <p>{{ $task->created_at->format('Y-n-j') }}</p>
    @endforeach
  @else
    <p>タスクがありません。</p>
  @endif


  {{-- フォーム --}}
  <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
    @csrf {{-- CSRFトークンは必須 --}}

    {{-- タスク名 --}}
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">タスク名</label>
        <input type="text" name="content" id="content" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="タスク名を入力" value="{{ old('content') }}" required>
    </div>

    {{-- 送信ボタン --}}
    <div>
        <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            作成
        </button>
    </div>

    <div id="app"></div>
    <script type="module" src="{{ mix('resources/js/app.js') }}"></script>

</form>

</body>
</html>
