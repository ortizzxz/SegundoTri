<!-- NoteFilter.vue -->
<script setup>
import { defineEmits } from 'vue';

const emit = defineEmits(['sort']);

function sortByRecent() {
  emit('sort', 'recent');
}

function sortByOldest() {
  emit('sort', 'oldest');
}
</script>

<template>
  <p>
    <a @click="sortByRecent">Filtrar por más recientes</a> || 
    <a @click="sortByOldest">Filtrar por más antiguas</a>
  </p>
</template>

<style scoped>
a:hover {
  cursor: pointer;
  padding: 0.5rem 0.5rem 0.2rem 0.5rem;
  border-radius: 1rem;
}

a {
  color: white;
  text-decoration: none;
}
</style>
