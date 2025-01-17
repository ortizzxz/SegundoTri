<script setup>
import { useRouter } from 'vue-router';
import {  useCurrentUser } from "vuefire";

const router = useRouter();
const user = useCurrentUser();

router.beforeEach(async (to, from) => {

  // if(user && to.fullPath == '/'){
  //   router.push('/notesApp');
  // }

  return true;
});

</script>

<template>
  <RouterView></RouterView>
</template>

<style computed>

</style>