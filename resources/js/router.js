import LandingPage from '../views/LandingPage.vue'
import CategoryPage from '../views/CategoryPage.vue'
import RegisterPage from '../views/RegisterPage.vue'
import LoginPage from '../views/LoginPage.vue'
import { createRouter, createWebHistory } from 'vue-router'
const routes = [
    {path: '/', component: LandingPage },
    {path: '/categories', component: CategoryPage} ,
    {path: '/register', component: RegisterPage},
    {path: '/login', component: LoginPage},
]
const router = createRouter({
    history: createWebHistory(),
    routes
})
export default router