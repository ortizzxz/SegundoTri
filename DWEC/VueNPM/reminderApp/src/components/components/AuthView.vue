<script setup>
import { ref } from 'vue';
import { GoogleAuthProvider } from "firebase/auth";
import { signInWithPopup } from "firebase/auth";
import { getCurrentUser, useCurrentUser, useFirebaseAuth } from "vuefire";
import { useRouter } from 'vue-router';


const user = useCurrentUser();
const auth = useFirebaseAuth();
const googleAuthProvider = new GoogleAuthProvider();
const router = useRouter();

const isLoading = ref(false);

function logIn() {
  isLoading.value = true;
  signInWithPopup(auth, googleAuthProvider)
    .then(() => {
      console.log("Validation successful");
      isLoading.value = false;
      router.push('/notesApp');
    })
    .catch((reason) => {
      console.error("Failed validation", reason);
      isLoading.value = false;
    });
}

router.beforeEach(async (to, from) => {
  if (to.meta.requiresAuth) {
    const user = await getCurrentUser();
    var isAllowed;
    if((user) ? isAllowed : !isAllowed)
    return isAllowed;
  }
  return true;  
});

</script>

<template>
  <div v-if="!user" class="login-container">
    <h1 class="login-title">Bienvenido</h1>
    <p class="login-subtitle">Inicie Sesión para acceder a la App</p>
    <button @click="logIn" class="login-button" :disabled="isLoading">
      <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google logo" class="google-icon">
      {{ isLoading ? 'Logging in...' : 'Log In with Google' }}
    </button>
  </div>

  <p v-else><RouterLink to="/notesApp">App</RouterLink></p>

</template>

<style scoped>
.login-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 75vh;
  background: rgb(5,23,37);
  background: radial-gradient(circle, rgba(5,23,37,1) 0%, rgba(7,0,65,1) 100%);  
  width: 20dvw;
  border-radius: 1rem;
  border: 1px solid white;
  margin: 10dvh auto;
}

.login-title {
  font-size: 2.5rem;
  margin-bottom: 0.5rem;
}

.login-subtitle {
  font-size: 1.2rem;
  margin-bottom: 2rem;
}

.login-button {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0.75rem 1.5rem;
  font-size: 1rem;
  color: #fff;
  background-color: #4285F4;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.login-button:hover {
  background-color: #3367D6;
}

.login-button:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

.google-icon {
  width: 18px;
  height: 18px;
  margin-right: 10px;
}
</style>
