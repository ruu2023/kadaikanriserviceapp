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
    <button @click="toggleModal">モーダルを開く</button>
    <Modal :isOpen="isModalOpen" @close="toggleModal">
      <p>モーダルの中身です</p>
    </Modal>

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
      <!-- タスクフォーム 切り替えあり -->
      <div class="flex-1 overflow-y-auto">
        <component :is="currentTabComponent"></component>
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
import Modal from './components/Modal.vue';

export default {
  components: {
    TaskForm,
    Archive,
    HeaderComponent,
    FooterComponent,
    SideBarComponent,
    Modal,
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

    // モーダルの表示状態
    const isModalOpen = ref(false);

    // モーダルの表示を切り替え
    const toggleModal = () => {
      isModalOpen.value = !isModalOpen.value;
    };

    return {
      isSidebarOpen,
      currentTab,
      currentTabComponent,
      toggleSidebar,
      updateTab,
      isModalOpen,
      toggleModal
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
