// import './bootstrap';

// import { createApp } from 'vue';

// import app from './components/App.vue';

// import router from './router'

// // createApp(app).mount('#app');
// createApp(app).use(router).mount('#app');

// import './bootstrap';
import '../css/app.css';

import { createApp, markRaw } from 'vue';
import { createPinia } from 'pinia'
import { useUserStore } from '@/stores/userStore';

import App from './components/app.vue';

import router from './router';

const pinia = createPinia()
const app = createApp(App)

pinia.use(({store}) => {
    store.router = markRaw(router)
})


app.use(pinia)
app.use(router)
const userStore = useUserStore();
userStore.loadUserFromLocalStorage();
app.mount('#app')
// createApp(app).use(router).mount('#app');