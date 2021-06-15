import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/about',
    name: 'About',
    component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
  },
  {
    path: '/adicionar',
    name: 'Adicionar',
    component: () => import(/* webpackChunkName: "add" */ '../views/Adicionar.vue')
  },
  {
    path: '/:pathMatch(.*)*',
    //name: 'NotFound',
    redirect: "/"
    //component: () => import(/* webpackChunkName: "add" */ '../views/NotFound.vue')
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router