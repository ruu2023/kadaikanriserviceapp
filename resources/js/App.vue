<template>
  <div class="flex flex-col h-screen">
    <!-- タスクフォーム -->
    <div class="flex-1 overflow-y-auto">
      <task-form></task-form>
    </div>
    <!-- フッター -->
    <div>
      <footer-component></footer-component>
    </div>
  </div>
</template>

<script>
import TaskForm from './components/TaskForm.vue';
import FooterComponent from './components/Footer.vue';

export default {
  components: {
    TaskForm,
    FooterComponent
  }
}
</script>

<style scoped>
/* 必要に応じてスタイルを追加 */
</style>
