<template>
  <header class="mr-4 flex justify-end w-full items-center p-2">
      <button
        v-if="props.currentTab == 'TaskForm'"
        @click="deleteAllTasks"
      >
        <i class="block fas fa-trash-alt"></i>
      </button>
      <button
        v-if="props.currentTab == 'Archive'"
        @click="deleteAllArchive"
      >
        <i class="block fas fa-trash-alt"></i>
      </button>
  </header>
</template>

<script setup>
import '@fortawesome/fontawesome-free/css/all.css'
import api from '../plugins/axios';
import { useTaskStore } from '@/stores/taskStore';

const taskStore = useTaskStore();

const props = defineProps({
  currentTab: {
    type: String,
    required: true
  }
});

const deleteAllTasks = async () => {
  const result = window.confirm('全てのタスクを削除してもよろしいですか？');

  if (!result) return;

  try {
    await api.delete('/tasks-delete');
    taskStore.tasks = []; // 全てのタスクをストアからクリア
  } catch (error) {
    console.error('全タスクの削除に失敗しました:', error);
  }
};

const deleteAllArchive = async () => {
  const result = window.confirm('アーカイブされた全てのタスクを削除してもよろしいですか？');

  if (!result) return;

  try {
    await api.delete('/archives-delete');
    taskStore.tasks = []; // 全てのタスクをストアからクリア
  } catch (error) {
    console.error('全タスクの削除に失敗しました:', error);
  }
};
</script>

<style scoped>
footer {
  background-color: #333;
  color: white;
  padding: 1rem;
  text-align: center;
}
</style>
