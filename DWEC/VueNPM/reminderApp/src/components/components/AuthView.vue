<script setup>
import { ref, watch, onMounted } from "vue";
import {
  GoogleAuthProvider,
  signInWithPopup,
  signInWithEmailAndPassword,
  createUserWithEmailAndPassword,
  GithubAuthProvider,
} from "firebase/auth";
import { useCurrentUser, useFirebaseAuth } from "vuefire";
import { useRouter } from "vue-router";

const user = useCurrentUser(); // Reactive user state
const auth = useFirebaseAuth();
const googleAuthProvider = new GoogleAuthProvider();
const router = useRouter();
const githubProvider = new GithubAuthProvider();

const isLoading = ref(false);
const email = ref("");
const password = ref("");
const passwordTwo = ref("");
const isSignUp = ref(false);
const emailError = ref("");
const passwordError = ref("");

function logInWithGoogle() {
  isLoading.value = true;
  signInWithPopup(auth, googleAuthProvider)
    .then(() => {
      isLoading.value = false;
      router.push("/notesApp");
    })
    .catch((reason) => {
      console.error("Failed Google validation", reason);
      isLoading.value = false;
    });
}

function signInWithGithub() {
  isLoading.value = true;
  signInWithPopup(auth, githubProvider)
    .then(() => {
      isLoading.value = false;
      router.push("/notesApp");
    })
    .catch((error) => {
      console.error("Failed GitHub sign-in", error);
      isLoading.value = false;
    });
}

function logInWithEmail() {
  isLoading.value = true;
  emailError.value = "";
  passwordError.value = "";
  signInWithEmailAndPassword(auth, email.value, password.value)
    .then(() => {
      isLoading.value = false;
      router.push("/notesApp");
    })
    .catch((error) => {
      console.error("Failed email/password login", error);
      isLoading.value = false;
      if (error.code === "auth/user-not-found") {
        emailError.value = "User not found";
      } else if (error.code === "auth/wrong-password") {
        passwordError.value = "Incorrect password";
      } else {
        emailError.value = error.message;
      }
    });
}

function signUpWithEmail() {
  if(password.value.trim() !== passwordTwo.value.trim()){
    passwordError.value = "Passwords doesn't match";
    return;
  }
  
  isLoading.value = true;
  emailError.value = "";
  passwordError.value = "";
  createUserWithEmailAndPassword(auth, email.value, password.value)
    .then(() => {
      isLoading.value = false;
      router.push("/notesApp");
    })
    .catch((error) => {
      console.error("Failed email/password sign up", error);
      isLoading.value = false;
      if (error.code === "auth/email-already-in-use") {
        emailError.value = "Email already in use";
      } else if (error.code === "auth/weak-password") {
        passwordError.value = "Password is too weak";
      } else {
        emailError.value = error.message;
      } 
    });
}

watch(user, (currentUser) => {
  if (currentUser) {
    router.push("/notesApp");
  }
});

onMounted(() => {
  if (user.value) {
    router.push("/notesApp");
  }
});
</script>

<template>
  <div v-if="!user" class="login-container">
    <h1 class="login-title">Bienvenido</h1>
    <p class="login-subtitle">Inicie Sesión para acceder a la App</p>

    <form
      @submit.prevent="isSignUp ? signUpWithEmail() : logInWithEmail()"
      class="login-form"
    > 
      <div class="input-group">
        <h2>Email</h2>
        <input
          v-model="email"
          type="email"
          placeholder="Email"
          required
          class="login-input"
        />
        <p v-if="emailError" class="error-message">{{ emailError }}</p>
      </div>
      <h2>Password</h2>
      <div class="input-group">
        <input
          v-model="password"
          type="password"
          placeholder="Password"
          required
          class="login-input"
        />
      <h2 v-if="isSignUp">Confirm Password</h2>
        <input 
          v-if="isSignUp"
          v-model="passwordTwo"
          type="password"
          placeholder="Confirm Password"
          required
          class="login-input"
        />
        <p v-if="passwordError" class="error-message">{{ passwordError }}</p>
      </div>
      <button type="submit" class="login-button" :disabled="isLoading">
        {{ isLoading ? "Processing..." : isSignUp ? "Sign Up" : "Log In" }}
      </button>
    </form>
    
    <p class="login-toggle">
      {{ isSignUp ? "Already have an account?" : "Don't have an account?" }}
      <a href="#" @click.prevent="isSignUp = !isSignUp">{{
        isSignUp ? "Log In" : "Sign Up"
      }}</a>
    </p>

    <div class="divider"></div>

    <button
    @click="logInWithGoogle"
    class="login-button google-button"
    :disabled="isLoading"
  >
    <img
      src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg"
      alt="Google logo"
      class="google-icon"
    />
    {{ isLoading ? "Processing..." : "Continue with Google" }}
  </button>

  <button
    @click="signInWithGithub"
    class="login-button github-button"
    :disabled="isLoading"
  >
    <img
      src="https://github.githubassets.com/images/modules/logos_page/GitHub-Mark.png"
      alt="GitHub logo"
      class="github-icon"
    />
    {{ isLoading ? "Processing..." : "Continue with GitHub" }}
  </button>
  </div>

  <p v-else><RouterLink to="/notesApp">App</RouterLink></p>
</template>

<style scoped>
h2{
  text-align: left;
}

.login-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  max-height: 90vh;
  background: rgb(5, 23, 37);
  background: radial-gradient(
    circle,
    rgba(5, 23, 37, 1) 0%,
    rgba(7, 0, 65, 1) 100%
  );
  width: 35dvw;
  border-radius: 1rem;
  border: 1px solid white;
  margin: 5dvh auto;
  padding: 2rem;
}

.login-title {
  font-size: 2.5rem;
  margin-bottom: 0.5rem;
}

.login-subtitle {
  font-size: 1.2rem;
  margin-bottom: 2rem;
}

.login-form {
  display: flex;
  flex-direction: column;
  width: 100%;
  margin-bottom: 1rem;
}

.login-input {
  font-size: 1rem;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.login-button {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0.75rem 1.5rem;
  font-size: 1rem;
  color: #fff;
  background-color: #4285f4;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.login-button:hover {
  background-color: #3367d6;
}

.login-button:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

.google-button {
  background-color: #fff;
  color: #757575;
  border: 1px solid #ddd;
  margin: 5px auto;
}

.google-button:hover {
  background-color: #f5f5f5;
}

.google-icon {
  width: 18px;
  height: 18px;
  margin-right: 10px;
}

.login-toggle {
  margin-top: 1rem;
}

.login-toggle a {
  color: #4285f4;
  text-decoration: none;
}

.divider {
  width: 100%;
  text-align: center;
  border-bottom: 1px solid #ccc;
  line-height: 0.1em;
  margin: 0.2rem 0;
}

.divider span {
  background: #fff;
  padding: 0 10px;
}
.input-group {
  position: relative;
  margin-bottom: 1rem;
}

.error-message {
  color: #ff4136;
  font-size: 0.8rem;
  margin-top: 0.25rem;
  margin-bottom: 0.25rem;
  position: absolute;
  bottom: -1.2rem;
  left: 0;
}

.login-input {
  width: 100%;
  padding: 0.5rem;
  font-size: 1rem;
  border: 1px solid #ccc;
  border-radius: 4px;
  transition: border-color 0.3s ease;
}

.login-input:focus {
  outline: none;
  border-color: #4285f4;
}

.login-input.error {
  border-color: #ff4136;
}


.github-button {
  background-color: #24292e;
  color: #ffffff;
}

.github-button:hover {
  background-color: #2f363d;
}

.github-icon {
  width: 18px;
  height: 18px;
  margin-right: 10px;
}



</style>
