<template>
  <footer class="bg-gray-800 text-white p-4 text-center">
    <p>&copy; {{ new Date().getFullYear() }} Your Company Name. All rights reserved.</p>
  </footer>
</template>

<script>
export default {
  name: 'Footer',
}
</script>

<style scoped>
footer {
  background-color: #333;
  color: white;
  padding: 1rem;
  text-align: center;
}
</style>
