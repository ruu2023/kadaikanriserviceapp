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

<script>
import api, { setAuthToken } from "../plugins/axios";

export default {
  data() {
    return {
      registerData: {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
      },
      loginData: {
        email: "",
        password: "",
      },
      dashboardMessage: "",
    };
  },
  methods: {
  // ユーザー登録
  async register() {
    try {
      const response = await api.post("/register", this.registerData, {
        withCredentials: true, // これを追加
      });
      alert("登録成功: " + response.data.message);
      setAuthToken(response.data.token); // トークンを設定
      this.$router.push("/dashboard"); // ダッシュボードにリダイレクト
    } catch (error) {
      console.error("登録エラー", error.response?.data);
      alert("登録エラー: " + JSON.stringify(error.response?.data));
    }
  },

  // ログイン
  async login() {
    try {
      const response = await api.post("/login", this.loginData, {
        withCredentials: true, // これを追加
      });
      alert("ログイン成功: " + response.data.message);
      console.log("Router:", this.$router); // ← ここで `this.$router` の状態を確認
      setAuthToken(response.data.token);
      this.$router.push("/dashboard"); // ダッシュボードにリダイレクト
    } catch (error) {
      alert("ログインエラー: " + (error.response?.data?.message || "不明なエラー"));
    }
  },

  // ログアウト
  async logout() {
    try {
      await api.post("/logout", {}, { withCredentials: true });
      localStorage.removeItem("token");
      this.$router.push("/login");
    } catch (error) {
      console.error("ログアウト失敗", error);
    }
  },

  // 認証が必要なエンドポイント
  async getDashboard() {
    try {
      const response = await api.get("/dashboard", { withCredentials: true });
      this.dashboardMessage = response.data.message;
    } catch (error) {
      alert("ダッシュボード取得エラー: " + (error.response?.data?.message || "不明なエラー"));
    }
  },
},

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
