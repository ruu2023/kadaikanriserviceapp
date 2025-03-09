<template>
  <div class="text-sm">
    <div class="flex items-center justify-between p-4 bg-gray-900">

      <!-- ユーザー名 -->
      <p class="ml-1 text-md text-white">{{ user.name }}</p>
      <!-- ログアウトボタン -->
      <form @submit.prevent="logout">
        <button type="submit" style="font-size:0.5rem;" class="text-xs text-cyan-200 p-2 border border-cyan-100">
            ログアウト
        </button>
      </form>

    </div>
    <div>
      <button @click="changeTab('TaskForm')" :class="{'bg-violet-900': selectedTab === 'TaskForm'}" class="block p-4 text-left w-full">Task</button>
      <button @click="changeTab('Archive')" :class="{'bg-violet-900': selectedTab === 'Archive'}" class="block p-4  text-left w-full">Archive</button>
      <!-- <a :href="route('home')" class="block p-4">Home</a> -->
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useAuthStore } from "../stores/authStore";
import { storeToRefs } from "pinia";

// emitsの定義
const emit = defineEmits(['tab-changed']);

// 状態管理
const selectedTab = ref("TaskForm");
const authStore = useAuthStore();
const { user } = storeToRefs(authStore);

// タブ切り替え処理
const changeTab = (tab) => {
  selectedTab.value = tab;
  emit("tab-changed", tab);
};

// ログアウト処理
const logout = async () => {
  try {
    await authStore.logout();
    window.location.href = '/login';
  } catch (error) {
    console.error("Logout failed:", error);
  }
};
</script>
