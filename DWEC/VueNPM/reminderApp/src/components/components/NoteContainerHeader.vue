<script setup>
import { signOut } from "firebase/auth";
import { useCurrentUser, useFirebaseAuth } from "vuefire";
import { useRouter } from "vue-router";

const user = useCurrentUser();
const auth = useFirebaseAuth();
const router = useRouter();

function logOut() {
  signOut(auth)
    .then(() => router.push("/"))
    .catch((reason) => {
      console.error("Failed signout", reason);
    });
}
</script>
<template>
  <div>
    <h1 v-if="user">
      Hola {{ user.displayName }} ||
      <span><font-awesome-icon :icon="['fas', 'arrow-right-from-bracket']" class="logout-span" @click="logOut" /></span>
    </h1>
  </div>
</template>

<style scoped>
div {
  margin: 0.5rem auto 0 0;
}
.logout-span {
  border: 1px solid rgb(75, 28, 28);
  display: inline-block;
  padding: 5px 20px;
  color: white;
  border-radius: 3px;
  cursor: pointer;
  font-size: 1.5rem;
  transition: background-color 0.3s ease;
  border-radius: 1rem;
}

.logout-span:hover {
  background-color: #571919;
}
</style>
