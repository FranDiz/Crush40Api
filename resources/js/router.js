import LandingPage from '../views/LandingPage.vue'
import CategoryPage from '../views/CategoryPage.vue'
import RegisterPage from '../views/RegisterPage.vue'
import LoginPage from '../views/LoginPage.vue'
import ProfilePage from '../views/ProfilePage.vue'
import AlbumPage from '../views/AlbumPage.vue'
import { createRouter, createWebHistory } from 'vue-router'
const routes = [
    {path: '/', component: LandingPage },
    {path:'/album/:id', component:AlbumPage},
    {path: '/categories', component: CategoryPage} ,
    {path: '/register', component: RegisterPage},
    {path: '/login', name:'Login', component: LoginPage},
    {path:'/profile', name:'Profile', component: ProfilePage, meta: {requiredAuth: true}}
]
const router = createRouter({
    history: createWebHistory(),
    routes
})
export default router