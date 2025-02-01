<template>
  <div class="sidebar">
    <h2>Sidebar</h2>
    <div>
      <p>ログイン中: {{ user.name }}</p>
      <!-- ログアウトボタン -->
      <form @submit.prevent="logout">
        <button type="submit">
            Logout
        </button>
      </form>
      <a :href="route('home')">Home</a>
    </div>
  </div>
</template>

<script>
export default {
  name: "SideBarComponent",
  setup() {
    return {
      user: window.Laravel.user,
      route
    };
  },
  methods: {
    async logout() {
      try {
          await axios.post('/logout')
          // ログアウト後にリダイレクト
          window.location.href = '/'
      } catch (error) {
          console.error('Logout failed:', error)
      }
    }
  }
};
</script>
