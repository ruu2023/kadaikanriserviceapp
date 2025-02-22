<template>
  <div class="flex flex-col h-full">

    <!-- タスク一覧 -->
    <div class="flex-1 scrollable p-8">
      <draggable
      v-model="taskStore.tasks"
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
            <div class="px-3 py-2 flex-1 flex space-x-2 items-center justify-between">
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
          v-model="inputContent"
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

<script setup>
import { onMounted, ref } from 'vue';
import { useTaskStore } from '@/stores/taskStore';

import api from '../plugins/axios';
import draggable from 'vuedraggable';

// タスクの状態管理
const taskStore = useTaskStore();

const inputContent = ref(''); // 入力フォーム
const errorMessage = ref(''); // エラーメッセージ

// 親コンポーネントへイベントを渡す
const emit = defineEmits(["task-selected"]);

// フォーカス（モーダル）を開く
const focusTask = (content, index) => {
  emit("task-selected");
  taskStore.selectedTask = {content, index};
};

// 日付フォーマット
const formatDate = (dateString) => dateString.split('T')[0];

// 初回ロード時にタスクを取得
const fetchTasks = async () => {
  try {
    const response = await api.get('/archives');
    taskStore.tasks = response.data;
  } catch (error) {
    console.error('タスク一覧の取得に失敗しました:', error);
  }
};

// フォーム送信時に新しいタスクを追加
const submitTask = async () => {
  errorMessage.value = ""; // 送信前にリセット
  try {
    const response = await api.post('/tasks', {
      content: inputContent.value,
    });

    const newTask = response.data;
    taskStore.tasks.unshift(newTask); // 先頭に追加

    await updateTaskOrder(); // 並び順のAPIリクエスト

    inputContent.value = ''; // 入力リセット
  } catch (error) {
    console.error('エラーが発生しました:', error.response?.data?.message || error);
    errorMessage.value = error.response?.data?.message || "不明なエラーが発生しました";
  }
};

// タスク並び替え
const updateTaskOrder = async () => {
  const updatedTasks = taskStore.tasks.map((task, index) => ({
    ...task,
    row_order: index + 1,
  }));

  try {
    await api.post("/update-order", { tasks: updatedTasks });
    console.log("タスク並び替え成功");
  } catch (error) {
    console.error("タスクの並び替え失敗:", error);
  }
};

// ドラッグ時の並び替え処理
const onDragEnd = async () => {
  await updateTaskOrder();
};

// コンポーネントマウント時にタスク取得
onMounted(fetchTasks);
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
