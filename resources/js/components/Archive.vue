<template>
  <div class="flex flex-col h-full">

    <!-- タスク一覧 -->
    <div class="flex-1 scrollable p-8">
      <ul>
        <li
          v-for="(element) in taskStore.tasks"
          :key="element.id"
          class="task mt-2 bg-slate-200 shadow-lg list-none p-2"
        >
          <!-- タスクの表示 -->
          <div class="flex items-center h-10 justify-between">
            <div class="px-3 py-2 flex-1 flex space-x-2 items-center justify-between">
              <p class="line-clamp-2 break-all w-full">{{ element.content }}</p>
            </div>
          </div>
        </li>
      </ul>
    </div>

  </div>

</template>

<script setup>
  import { onMounted, ref } from 'vue';
  import { useTaskStore } from '@/stores/taskStore';

  import api from '../plugins/axios';

  // タスクの状態管理
  const taskStore = useTaskStore();

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

  // コンポーネントマウント時にタスク取得
  onMounted(fetchTasks);
  </script>

  <style>
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
