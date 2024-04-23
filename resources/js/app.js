import './bootstrap';
import {createApp} from 'vue';
import router from "./router"
import LandingPage from '../views/LandingPage.vue';

createApp(LandingPage).use(router).mount("#app");