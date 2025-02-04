<template>
  <button @click="logout">ログアウト</button>
  <div class="auth-container">
    <h2>ユーザー登録</h2>
    <form @submit.prevent="register">
      <input type="text" v-model="registerData.name" placeholder="名前" required />
      <input type="email" v-model="registerData.email" placeholder="メールアドレス" required />
      <input type="password" v-model="registerData.password" placeholder="パスワード" required />
      <input type="password" v-model="registerData.password_confirmation" placeholder="確認用パスワード" required />
      <button type="submit">登録</button>
    </form>

    <h2>ログイン</h2>
    <form @submit.prevent="login">
      <input type="email" v-model="loginData.email" placeholder="メールアドレス" required />
      <input type="password" v-model="loginData.password" placeholder="パスワード" required />
      <button type="submit">ログイン</button>
    </form>

    <button @click="logout">ログアウト</button>

    <h2>ダッシュボード</h2>
    <button @click="getDashboard">ダッシュボード情報取得</button>
    <p v-if="dashboardMessage">{{ dashboardMessage }}</p>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useAuthStore } from "@/stores/authStore";
import { useRouter } from "vue-router";
import api from "../plugins/axios";

const authStore = useAuthStore();
const router = useRouter();

const registerData = ref({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});

const loginData = ref({
  email: "",
  password: "",
});

const dashboardMessage = ref("");

// ユーザー登録
const register = async () => {
  try {
    await authStore.register(registerData.value);
    router.push("/dashboard");
  } catch (error) {
    console.error("登録エラー", error);
    alert("登録エラー: " + error.message);
  }
};

// ログイン
const login = async () => {
  try {
    await authStore.login(loginData.value);
    router.push("/dashboard");
  } catch (error) {
    console.error("ログインエラー", error);
    alert("ログインエラー: " + error.message);
  }
};

// ログアウト
const logout = async () => {
  await authStore.logout();
};

// ダッシュボード情報取得
const getDashboard = async () => {
  try {
    const response = await api.get("/dashboard", { withCredentials: true });
    dashboardMessage.value = response.data.message;
  } catch (error) {
    alert("ダッシュボード取得エラー: " + (error.response?.data?.message || "不明なエラー"));
  }
};
</script>

<style>
.auth-container {
  max-width: 400px;
  margin: auto;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 5px;
  box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
}
input {
  width: 100%;
  padding: 8px;
  margin: 5px 0;
  border: 1px solid #ddd;
  border-radius: 4px;
}
button {
  width: 100%;
  padding: 10px;
  margin-top: 10px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
</style>
