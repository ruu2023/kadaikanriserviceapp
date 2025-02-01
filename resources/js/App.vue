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
      <!-- タスクフォーム -->
      <div class="flex-1 overflow-y-auto">
        <component :is="currentTabComponent"></component>
      </div>
      <!-- フッター -->
      <div>
        <footer-component></footer-component>
      </div>
    </div>
  </div><!-- /.flex -->
</template>

<script>
import TaskForm from './components/TaskForm.vue';
import Archive from './components/Archive.vue';
import HeaderComponent from './components/Header.vue';
import FooterComponent from './components/Footer.vue';
import SideBarComponent from './components/SideBar.vue';

export default {
  components: {
    TaskForm,
    Archive,
    HeaderComponent,
    FooterComponent,
    SideBarComponent,
  },
  data() {
    return {
      isSidebarOpen: false, // サイドバーが開いているかどうか
      currentTab: 'TaskForm',  // 初期表示
    };
  },
  computed: {
    currentTabComponent() {
      if (this.currentTab === 'TaskForm') {
        return 'TaskForm';
      } else if (this.currentTab === 'Archive') {
        return 'Archive';
      }
      return 'TaskForm';  // デフォルト
    }
  },
  methods: {
    toggleSidebar() {
      this.isSidebarOpen = !this.isSidebarOpen;
    },
    updateTab(tab) {
      this.currentTab = tab;
    }
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
