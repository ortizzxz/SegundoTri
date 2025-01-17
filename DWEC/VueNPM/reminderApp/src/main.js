import "./assets/main.css";
import App from "./App.vue";

import AuthView from "./components/components/AuthView.vue";
import NotesApp from "./components/components/notesApp.vue";

import { createApp } from "vue";

import firebaseApp from "./firebase.js";
import { VueFire, VueFireAuth, useCurrentUser } from "vuefire";
import { createRouter, createWebHistory } from "vue-router";

import { library } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faDeleteLeft, faUserSecret, faArrowRightFromBracket } from "@fortawesome/free-solid-svg-icons";

const routes = [
  { path: "/", component: AuthView, meta: { requiresAuth: false } },
  { path: "/notesApp", component: NotesApp, meta: { requiresAuth: true } },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// router.beforeEach((to, from, next) => {
//   const user = useCurrentUser(); 
//   if (to.meta.requiresAuth && !user.value) {
//     next("/");
//   } else {
//     next();
//   }
// });

const app = createApp(App);
app.component("font-awesome-icon", FontAwesomeIcon);

app.use(VueFire, {
  firebaseApp,
  modules: [VueFireAuth()],
});

app.use(router);

library.add(faUserSecret);
library.add(faDeleteLeft);
library.add(faArrowRightFromBracket);

app.mount("#app");
