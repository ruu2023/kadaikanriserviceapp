<template>
  <div class="text-sm">
    <div class="flex items-center justify-between p-4 bg-gray-900">
      <p>{{ user.name }}</p>
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

<script>
import { ref } from "vue";
import axios from "axios";

export default {
  name: "SideBar",
  setup(_, { emit }) {
    const user = ref(window.Laravel.user); // `ref()` を使ってリアクティブに
    const selectedTab = ref("TaskForm");   // 初期タブをリアクティブに管理

    const changeTab = (tab) => {
      selectedTab.value = tab;
      emit("tab-changed", tab); // 親コンポーネントにイベントを送信
    };

    const logout = async () => {
      try {
        await axios.post(route("logout"));
        window.location.href = route("home"); // ログアウト後にリダイレクト
      } catch (error) {
        console.error("Logout failed:", error);
      }
    };

    return {
      user,
      selectedTab,
      changeTab,
      logout
    };
  },
};
</script>
