<template>
  <div>
    <form @submit.prevent="submitTask" class="space-y-4">
      <!-- タスク名 -->
      <div>
        <label for="content" class="block text-sm font-medium text-gray-700">タスク名</label>
        <input
          type="text"
          v-model="state.content"
          id="content"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
          placeholder="タスク名を入力"
          required
        />
      </div>

      <!-- 送信ボタン -->
      <div>
        <button
          type="submit"
          class="w-full inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
        >
          作成
        </button>
      </div>
    </form>

    <!-- タスク一覧 -->
    <div class="mt-4">
      <h2 class="text-lg font-semibold">タスク一覧</h2>
      <ul>
        <li v-for="task in state.tasks" :key="task.id" class="mt-2">
          {{ task.content }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { reactive, onMounted } from 'vue';
import axios from 'axios';

export default {
  setup() {
    const state = reactive({
      content: '', // フォームの入力値
      tasks: [], // タスク一覧
    });

    // 初回ロード時に既存のタスクを取得
    const fetchTasks = async () => {
      try {
        const response = await axios.get('/tasks'); // APIからタスク一覧を取得
        state.tasks = response.data;
      } catch (error) {
        console.error('タスク一覧の取得に失敗しました:', error);
      }
    };

    // フォーム送信時に新しいタスクを追加
    const submitTask = async () => {
      try {
        const response = await axios.post('/tasks', {
          content: state.content,
        });

        const newTask = response.data; // サーバーから返ってきたタスクを取得
        state.tasks.push(newTask); // タスク一覧に追加
        state.content = ''; // 入力フィールドをリセット
      } catch (error) {
        console.error('エラーが発生しました:', error);
      }
    };

    onMounted(fetchTasks); // コンポーネントのマウント時にタスク一覧を取得

    return {
      state,
      submitTask,
    };
  },
};
</script>
