<template>
  <div class="sidebar">
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
          await axios.post(route('logout'))
          // ログアウト後にリダイレクト
          window.location.href = route('home')
      } catch (error) {
          console.error('Logout failed:', error)
      }
    }
  }
};
</script>
