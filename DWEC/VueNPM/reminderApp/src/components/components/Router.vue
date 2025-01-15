<script setup>
import { ref, computed } from 'vue';
import App from '@/App.vue';
import LogIn from './LogIn.vue';
import NotFound from './NotFound.vue';

const routes = {
  '/': LogIn,
  '/app': App
}

const currentPath = ref(window.location.hash)

window.addEventListener('hashchange', () => {
  currentPath.value = window.location.hash
})

const currentView = computed(() => {
  return routes[currentPath.value.slice(1) || '/'] || NotFound
})
</script>

<template>
  <component :is="currentView" />
</template>