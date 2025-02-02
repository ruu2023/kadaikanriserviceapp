<template>
  <div class="flex flex-col h-full">

    <!-- タスク一覧 -->
    <div class="flex-1 scrollable p-8">
      <draggable
      v-model="state.tasks"
      @end="onDragEnd"
      animation="200"
      itemKey="id"
      ghost-class="dragging"
      chosen-class="chosen"
      >
        <template #item="{ element, index }">
        <li :key="element.id" class="task mt-2 bg-slate-200 shadow-lg list-none p-2">
          <!-- タスクの表示 -->
          <div
          @click="focusTask(element.content, index)"
          class="flex items-center h-10 justify-between"
          >
            <div class="px-3 py-2 flex-1 flex justify-between">
              <!-- TODO:hiddenを修正 -->
              <p class="line-clamp-2 break-all w-full">{{ element.content }}</p> <p class="hidden">{{ formatDate(element.created_at) }}</p>
            </div>
          </div>
        </li>
      </template>
    </draggable>
    </div>

    <!-- エラーメッセージ表示 -->
    <p v-if="errorMessage" class="text-red-500">{{ errorMessage }}</p>

    <form @submit.prevent="submitTask" class="flex items-center w-full space-x-2 my-4 p-2">
      <!-- タスク名 -->
      <div class="flex-1">
        <input
          type="text"
          v-model="state.content"
          id="content"
          class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
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

  </div>
</template>

<script>
import { reactive, onMounted, ref } from 'vue';
import axios from 'axios';
import draggable from 'vuedraggable';

export default {
  name: 'TaskForm',
  components: {
    draggable
  },
  setup(_, { emit }) {
    const state = reactive({
      content: '', // フォームの入力値
      tasks: [], // タスク一覧
    });

    const editIndex = ref(null); // 編集中のインデックス
    const editedContent = ref(""); // 編集中の内容
    const errorMessage = ref(""); // エラーメッセージを格納

    // フォーカス（モーダル）を開く
    const focusTask = (content, index) => {
      emit("task-selected"); // 親コンポーネントにイベントを送信
      emit("task", {content, index}); // 親コンポーネントにイベントを送信
    }

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
      errorMessage.value = ""; // 送信前にリセット
      try {
        const response = await axios.post('/tasks', {
          content: state.content,
        });

        const newTask = response.data; // サーバーから返ってきたタスクを取得
        state.tasks.unshift(newTask); // タスク一覧に追加

        // 並び順のAPIリクエストを送信
        await updateTaskOrder();

        state.content = ''; // 入力フィールドをリセット
      } catch (error) {
        console.error('エラーが発生しました:', error.response.data.message);
        if (error.response && error.response.data.message) {
          errorMessage.value = error.response.data.message; // エラー内容をセット
        } else {
          errorMessage.value = "不明なエラーが発生しました";
        }
      }
    };

    // タスク並び替え
    const updateTaskOrder = async () => {
      const updatedTasks = state.tasks.map((task, index) => ({
        ...task,
        row_order: index + 1,
      }));

      try {
        await axios.post("/update-order", {
          tasks: updatedTasks,
        });
        console.log("Order updated successfully");
      } catch (error) {
        console.error("Error updating order:", error);
      }
    };

    // ドラッグ時にタスクの並び替え
    const onDragEnd = async () => {
      await updateTaskOrder();
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
      errorMessage,
      submitTask,
      formatDate,
      focusTask,
      deleteTask,
      onDragEnd,
    };
  },
};
</script>
<style>
/* ドラッグ中の要素 */
.dragging {
  opacity: 0;
}
/* スクロール可能範囲 */
.scrollable {
  overflow: auto;
}
/* スクロールバーの非表示 */
.scrollable::-webkit-scrollbar {
  display: none;
}
/* タスク単体 */
.task {
  cursor: pointer;
}
</style>
