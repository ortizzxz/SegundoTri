import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
import { VueFire, VueFireAuth } from 'vuefire'
import firebaseApp from './firebase.js';

// createApp(App).mount('#app')

const app = createApp(App);
app.use(VueFire, {
    firebaseApp,
    modules: [
        VueFireAuth(),
    ],      
})

app.mount('#app');