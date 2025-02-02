<template>
  <div class="flex h-screen">
    <!-- サイドバー -->
    <div
      :class="{
        'show': isSidebarOpen
      }"
      class="sidebar fixed md:static md:l-0! inset-y-0 w-64 z-50 text-white bg-slate-800 transition-transform duration-300"
    >
      <side-bar-component @tab-changed="updateTab" ></side-bar-component>
    </div>

    <!-- オーバーレイ（サイドバーが開いているときのみ表示） -->
    <div v-if="isSidebarOpen" class="fixed md:hidden inset-0 bg-black bg-opacity-50 z-40" @click="toggleSidebar"></div>

    <!-- モーダル -->
    <modal-component :isOpen="isModalOpen" @close="toggleModal">
      <edit-task :task="selectedTask"></edit-task>
    </modal-component>

    <!-- メインコンテンツ -->
    <div class="flex flex-1 flex-col h-full">
      <!-- ヘッダー -->
      <div class="flex">
        <!-- ハンバーガーメニュー -->
        <div class="md:hidden">
          <button @click="toggleSidebar" class="p-4">☰</button>
        </div>
        <header-component></header-component>
      </div>
      <!-- タスクフォーム 切り替え -->
      <div class="flex-1 overflow-y-auto">
        <component :is="currentTabComponent" @task-selected="toggleModal" @task="handleTask"></component>
      </div>
      <!-- フッター -->
      <div>
        <footer-component></footer-component>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed } from "vue";
import TaskForm from './components/TaskForm.vue';
import Archive from './components/Archive.vue';
import HeaderComponent from './components/Header.vue';
import FooterComponent from './components/Footer.vue';
import SideBarComponent from './components/SideBar.vue';
import ModalComponent from './components/Modal.vue';
import EditTask from './components/EditTask.vue';

export default {
  components: {
    TaskForm,
    Archive,
    HeaderComponent,
    FooterComponent,
    SideBarComponent,
    ModalComponent,
    EditTask
  },
  setup() {
    // サイドバーの開閉状態
    const isSidebarOpen = ref(false);

    // 現在のタブ
    const currentTab = ref("TaskForm");

    // 表示するコンポーネントを計算
    const currentTabComponent = computed(() => {
      return currentTab.value === "Archive" ? "Archive" : "TaskForm";
    });

    // サイドバーの開閉を切り替え
    const toggleSidebar = () => {
      isSidebarOpen.value = !isSidebarOpen.value;
    };

    // タブの変更
    const updateTab = (tab) => {
      currentTab.value = tab;
    };

    // モーダルに表示する内容
    const selectedTask = ref(null);

    // モーダルの表示状態
    const isModalOpen = ref(false);

    // モーダルの表示を切り替え
    const toggleModal = () => {
      isModalOpen.value = !isModalOpen.value;
    };

    // 選択されたタスクを設定
    const handleTask = (task) => {
      selectedTask.value = task;
    }

    return {
      isSidebarOpen,
      currentTab,
      currentTabComponent,
      toggleSidebar,
      updateTab,
      selectedTask,
      isModalOpen,
      toggleModal,
      handleTask
    };
  },
}
</script>

<style scoped>
/* サイドバーが開いているときのスタイル */
.sidebar {
  left: -100%;
  transition: left 0.3s ease;
}
.sidebar.show {
  left: 0;
}

/* ハンバーガーメニュー */
button {
  background-color: transparent;
  border: none;
  font-size: 24px;
}
</style>
