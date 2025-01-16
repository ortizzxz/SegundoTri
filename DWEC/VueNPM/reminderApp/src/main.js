import "./assets/main.css";

import App from "./App.vue";
import firebaseApp from "./firebase.js";
import { createApp } from "vue";
import { VueFire, VueFireAuth } from "vuefire";
import { createRouter, createWebHistory } from "vue-router";
import AuthView from "./components/components/AuthView.vue";
import NotesApp from "./components/components/notesApp.vue";
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faUserSecret } from '@fortawesome/free-solid-svg-icons'
import { faDeleteLeft } from '@fortawesome/free-solid-svg-icons'
import { faArrowRightFromBracket } from "@fortawesome/free-solid-svg-icons";


const routes = [
  { path: "/", component: AuthView, meta:{requiresAuth: false} },
  { path: "/notesApp", component: NotesApp, meta:{requiresAuth: true} },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

const app = createApp(App);
app.component('font-awesome-icon', FontAwesomeIcon);

app.use(VueFire, {
  firebaseApp,
  modules: [VueFireAuth()],
});

app.use(router);
library.add(faUserSecret);
library.add(faDeleteLeft);
library.add(faArrowRightFromBracket);


app.mount("#app");
