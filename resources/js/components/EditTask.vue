<template>
  <div class="flex flex-col h-full">
    EditTask
    <!-- エラーメッセージ表示 -->
    <!-- <p v-if="errorMessage" class="text-red-500">{{ errorMessage }}</p> -->
    <!-- タスクの表示または編集 -->
<!--
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
-->
  </div>
</template>

<script>
import { reactive, onMounted, ref } from 'vue';
import axios from 'axios';
// import draggable from 'vuedraggable';

export default {
  name: 'EditTask',
  setup() {
  },
};
</script>
<style>
/* スタイルを指定 */
</style>
