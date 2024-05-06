import LandingPage from '../views/LandingPage.vue'
import CategoryPage from '../views/CategoryPage.vue'
import RegisterPage from '../views/RegisterPage.vue'
import LoginPage from '../views/LoginPage.vue'
import ProfilePage from '../views/ProfilePage.vue'
import AlbumPage from '../views/AlbumPage.vue'
import PlaylistsPage from '../views/PlaylistsPage.vue'
import { createRouter, createWebHistory } from 'vue-router'
import PlaylistPage from '../views/PlaylistPage.vue'
const routes = [
    {path: '/', component: LandingPage },
    {path:'/album/:id', component:AlbumPage},
    {path: '/categories', component: CategoryPage} ,
    {path: '/register', component: RegisterPage},
    {path: '/login', name:'Login', component: LoginPage},
    {path:'/profile', name:'Profile', component: ProfilePage, meta: {requiredAuth: true}},
    {path:'/playlists', name:'Playlists', component: PlaylistsPage},
    {path: '/playlist:id', name:'Playlist', component: PlaylistPage}
]
const router = createRouter({
    history: createWebHistory(),
    routes
})
export default router