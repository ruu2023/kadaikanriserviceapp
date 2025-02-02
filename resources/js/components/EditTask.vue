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
          @click="cancelEdit"
          class="text-gray-500 hover:underline ml-2"
        >
          キャンセル
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useTaskStore } from '@/stores/taskStore';
import axios from "axios";

// タスクの状態管理
const taskStore = useTaskStore();

// 親コンポーネントから `task` を受け取る
const props = defineProps({
  task: Object, // 親から受け取る
});

// 親コンポーネントへイベントを渡す
const emit = defineEmits(["close"]);

// 編集中のインデックスと内容を管理
const editedContent = ref(taskStore.selectedTask.content);

// 更新
const updateTask = async (index) => {
  try {
    const task = taskStore.tasks[index]; // 対象タスクを取得

    // API 呼び出し
    const response = await axios.put(`/tasks/${task.id}`, {
      content: editedContent.value, // 更新する内容
    });

    // ローカル状態の更新
    taskStore.tasks[index].content = response.data.content; // サーバーからの応答で更新

    console.log("タスク更新成功:", response.data);
  } catch (error) {
    console.error("タスク更新失敗:", error);
  }

  cancelEdit(); // 編集終了
};

// 編集キャンセル
const cancelEdit = () => {
  // モーダルを閉じる
  emit("close");
};
</script>
<style>
/* スタイルを指定 */
</style>
