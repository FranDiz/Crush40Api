import LandingPage from '../views/LandingPage.vue'
import CategoryPage from '../views/CategoryPage.vue'

import { createRouter, createWebHistory } from 'vue-router'

const routes = [
    { path: '/', component: LandingPage },
    {path: '/categories', component: CategoryPage} ,
]
const router = createRouter({
    history: createWebHistory(),
    routes
})
export default router