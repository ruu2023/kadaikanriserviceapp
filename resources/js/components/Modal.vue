<template>
  <div v-if="isOpen" class="modal-overlay" @click.self="closeModal">
    <div class="modal-content">
      <slot></slot>
      <!-- <button @click="closeModal" class="modal-close">閉じる</button> -->
    </div>
  </div>
</template>

<script setup>
import { defineProps, defineEmits } from "vue";

const props = defineProps({
  isOpen: Boolean, // 親コンポーネントからpropsの受取り
});

const emit = defineEmits(["close"]);

const closeModal = () => {
  emit("close"); // 親コンポーネントにイベントを送信
};
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  inset: 0px;
  background: rgba(0, 0, 0, 0.9);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: white;
  padding: 20px;
  border-radius: 8px;
}

.modal-close {
  margin-top: 10px;
  padding: 5px 10px;
  background: red;
  color: white;
  border: none;
  cursor: pointer;
}
</style>
