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
        <li v-for="(task, index) in state.tasks" :key="task.id" class="mt-2">
          <!-- タスクの表示または編集 -->
          <div v-if="editIndex === index">
            <input
              v-model="editedContent"
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            />
            <div class="flex space-x-2 mt-2">
              <button
                @click="updateTask(index)"
                class="text-green-500 hover:underline"
              >
                更新
              </button>
              <button
                @click="cancelEdit"
                class="text-gray-500 hover:underline"
              >
                キャンセル
              </button>
            </div>
          </div>
          <div v-else>
            {{ task.content }} {{ formatDate(task.created_at) }}
            <button
              @click="startEdit(index, task.content)"
              class="text-blue-500 hover:underline ml-2"
            >
              編集
            </button>
            <button
              @click="deleteTask(task.id)"
              class="text-red-500 hover:underline ml-2"
            >
              削除
            </button>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { reactive, onMounted, ref } from 'vue';
import axios from 'axios';

export default {
  setup() {
    const state = reactive({
      content: '', // フォームの入力値
      tasks: [], // タスク一覧
    });

    const editIndex = ref(null); // 編集中のインデックス
    const editedContent = ref(""); // 編集中の内容

    // 編集開始
    const startEdit = (index, content) => {
      editIndex.value = index;
      editedContent.value = content;
    };

    // 更新
    const updateTask = async(index) => {
      try {
        const task = state.tasks[index]; // 対象タスクを取得

        // API呼び出し
        const response = await axios.put(`/tasks/${task.id}`, {
          content: editedContent.value, // 更新する内容
        });

        // ローカル状態の更新
        state.tasks[index].content = response.data.content; // サーバーからの応答で更新

        console.log("タスク更新成功:", response.data);
      } catch (error) {
        console.error("タスク更新失敗:", error);
      }

      cancelEdit(); // 編集終了
    };

    // 編集キャンセル
    const cancelEdit = () => {
      editIndex.value = null;
      editedContent.value = "";
    };

    // 日付フォーマット用のメソッド
    const formatDate = (dateString) => {
      return dateString.split('T')[0];
    };

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

    // タスク削除
    const deleteTask = async (id) => {
      try {
        // API呼び出し
        await axios.delete(`/tasks/${id}`);

        // ローカル状態から削除
        state.tasks = state.tasks.filter((task) => task.id !== id);
      } catch (error) {
        console.error("タスク削除失敗:", error);
      }
    };

    onMounted(fetchTasks); // コンポーネントのマウント時にタスク一覧を取得

    return {
      state,
      editIndex,
      editedContent,
      submitTask,
      formatDate,
      editedContent,
      startEdit,
      updateTask,
      cancelEdit,
      deleteTask,
    };
  },
};
</script>
