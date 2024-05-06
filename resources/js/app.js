import './bootstrap';
import {createApp} from 'vue';
import router from "./router"
import App from '../views/App.vue'
import store from "./store.js"

createApp(App).use(router).use(store).mount("#app");
store.dispatch('initializeUser');