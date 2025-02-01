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
        <li :key="element.id" class="mt-2 bg-slate-200 shadow-lg list-none p-2">
          <!-- タスクの表示または編集 -->
          <form
            v-if="editIndex === index"
            @submit.prevent="updateTask(index)"
            class="flex items-center h-10 justify-between"
          >
            <input
              v-model="editedContent"
              class="block flex-1 px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            />
            <div>
              <button
                type="submit"
                class="text-green-500 hover:underline ml-2"
              >
                更新
              </button>
              <button
                type="button"
                @click="cancelEdit"
                class="text-gray-500 hover:underline ml-2"
              >
                キャンセル
              </button>
            </div>
          </form>
          <div
          v-else
          class="flex items-center h-10 justify-between"
          >
            <p class="px-3 py-2 flex-1 flex justify-between">
              <!-- TODO:hiddenを修正 -->
              <p>{{ element.content }}</p> <p class="hidden">{{ formatDate(element.created_at) }}</p>
            </p>
            <div>
              <button
                @click="startEdit(index, element.content)"
                class="text-blue-500 hover:underline ml-2"
              >
                編集
              </button>
              <!-- TODO:hiddenを修正 -->
              <button
                @click="deleteTask(element.id)"
                class="text-red-500 hover:underline ml-2 hidden"
              >
                削除
              </button>
            </div>
          </div>
        </li>
      </template>
    </draggable>
    </div>

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

    // タスク並び替え
    const onDragEnd = async () => {
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
</style>
