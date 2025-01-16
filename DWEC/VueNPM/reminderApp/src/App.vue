<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();

router.beforeEach((to, from) => {
  if (to.fullPath == "/notesApp") {
    return true;
  }
  return true;
});
</script>

<template>
  <RouterView></RouterView>
</template>

<style computed>
ul{
  display: flex;
  flex-direction: row;
}

ul li{
  margin: 1rem;
}
</style>