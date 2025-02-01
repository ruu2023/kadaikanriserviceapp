<template>
  <header class="flex justify-between items-center p-2 text-center">
    <p>&copy; {{ new Date().getFullYear() }} Your Company Name. All rights reserved.</p>
  </header>
</template>

<script>
export default {
  name: 'Header',
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
