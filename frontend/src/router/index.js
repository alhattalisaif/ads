import { createRouter, createWebHistory } from 'vue-router'
import Login from '../pages/Login.vue'
import Dashboard from '../pages/Dashboard.vue'
import CreateAd from '../pages/CreateAd.vue'
import Wallet from '../pages/Wallet.vue'
import UserProfile from '../pages/UserProfile.vue'

const routes = [
  { path: '/', component: Dashboard },
  { path: '/login', component: Login },
  { path: '/ads/create', component: CreateAd },
  { path: '/wallet', component: Wallet },
  { path: '/user', component: UserProfile }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
