<template>
  <div class="flex flex-col h-full">
    EditTask
    <!-- エラーメッセージ表示 -->
    <!-- <p v-if="errorMessage" class="text-red-500">{{ errorMessage }}</p> -->
    <!-- タスクの表示または編集 -->
    <form
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
  </div>
</template>

<script>
import axios from 'axios';
// import draggable from 'vuedraggable';

export default {
  name: 'EditTask',
  setup() {

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

    return {
      startEdit,
      updateTask,
      cancelEdit
    }
  },
};
</script>
<style>
/* スタイルを指定 */
</style>
