import { createRouter, createWebHistory } from 'vue-router'

import Home from '../views/Home.vue'
import ListPets from '../views/ListPets.vue'
import FormPet from '../views/FormPet.vue'
import Login from '../views/Login.vue'
import ListProfessionals from '../views/ListProfessionals.vue'
import Aprendizado from '../views/Aprendizado.vue'
import FormUser from '../views/FormUser.vue'

const routes = [
  {
    path: '/',
    name: 'login',
    component: Login
  },
  {
    path: '/home',
    name: 'home',
    component: Home
  },
  {
    path: '/pets/editar/:id',
    name: 'FormPetEdit',
    component: FormPet
  },
  {
    path: '/pets/:id',
    name: 'ListPets',
    component: ListPets
  },
  {
    path: '/pets/novo',
    name: 'FormPet',
    component: FormPet
  },
  {
    path: '/veterinarios',
    name: 'List professionals',
    component: ListProfessionals
  },
  ,
  {
    path: '/usuarios',
    name: 'FormUser',
    component: FormUser
  },
  {
    path: '/aprendizado',
    name: 'aprendizado',
    component: Aprendizado
  }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: routes
})

export default router