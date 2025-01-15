<script setup>
import { GoogleAuthProvider } from "firebase/auth";
import { signInWithPopup, signOut } from "firebase/auth";
import { useCurrentUser, useFirebaseAuth } from "vuefire";

const user = useCurrentUser();
const auth = useFirebaseAuth();
const googleAuthProvider = new GoogleAuthProvider();

function logIn() {
  signInWithPopup(auth, googleAuthProvider)
    .then(() => console.log("validacion correcta"))
    .catch((reason) => {
      console.error("Failed validation", reason);
    });
}
function logOut() {
  signOut(auth)
    .then(() => console.log("signout correcto"))
    .catch((reason) => {
      console.error("Failed signout", reason);
    });
}
</script>
<template>
    <h1 v-if="user">
      Hola {{ user.displayName }} -
      <span @click="logOut" class="logout-span">Log Out</span>
    </h1>
  </template>
  
  <style scoped>
  .logout-span {
    border: 1px solid rgb(75, 28, 28);
    display: inline-block;
    padding: 5px 10px;
    color: white;
    border-radius: 3px;
    cursor: pointer;
    font-size: 1.5rem;
    transition: background-color 0.3s ease;
  }
  
  .logout-span:hover {
    background-color: #d32f2f;
  }
  </style>
  