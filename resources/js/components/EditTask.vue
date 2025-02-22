<template>
  <div class="flex flex-col h-full">
    <!-- エラーメッセージ表示 -->
    <!-- <p v-if="errorMessage" class="text-red-500">{{ errorMessage }}</p> -->
    <!-- タスクの表示または編集 -->
    {{ taskStore.selectedTask.content }}
    <form
      @submit.prevent="updateTask(taskStore.selectedTask.index)"
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
          @click="exitEdit"
          class="text-gray-500 hover:underline ml-2"
        >
          キャンセル
        </button>
      </div>
    </form>
    <!-- 削除ボタン -->
    <button
      @click="deleteTask(taskStore.selectedTask.index)"
      class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-700"
    >
      削除
    </button>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useTaskStore } from '@/stores/taskStore';
import api from "../plugins/axios";

// タスクの状態管理
const taskStore = useTaskStore();

// 親コンポーネントへイベントを渡す
const emit = defineEmits(["close"]);

// 編集中のインデックスと内容を管理
const editedContent = ref(taskStore.selectedTask.content);

// 更新
const updateTask = async (index) => {
  try {
    const task = taskStore.tasks[index]; // 対象タスクを取得

    // API 呼び出し
    const response = await api.put(`/tasks/${task.id}`, {
      content: editedContent.value, // 更新する内容
    });

    // ローカル状態の更新
    taskStore.tasks[index].content = response.data.content; // サーバーからの応答で更新

    console.log("タスク更新成功:", response.data);
  } catch (error) {
    console.error("タスク更新失敗:", error);
  }

  exitEdit(); // 編集終了
};

// タスク削除
const deleteTask = async (index) => {
  try {
    const task = taskStore.tasks[index];// 対象タスクを取得
    // API呼び出し
    await api.delete(`/tasks/${task.id}`);

    // ローカル状態から削除
    taskStore.tasks = taskStore.tasks.filter((t) => t.id !== task.id);
  } catch (error) {
    console.error("タスク削除失敗:", error);
  }

  exitEdit(); // 編集終了
};

// 編集キャンセル
const exitEdit = () => {
  // モーダルを閉じる
  emit("close");
};
</script>
<style>
/* スタイルを指定 */
</style>
