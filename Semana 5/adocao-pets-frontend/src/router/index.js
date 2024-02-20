import { createRouter, createWebHistory } from 'vue-router'

import Main from '../views/Main.vue'
import Home1 from '../views/pessoa1/Home.vue'
import Home2 from '../views/Caroline/Home.vue'
import Home3 from '../views/Gabriel/Home.vue'
import Home4 from '../views/pessoa4/Home.vue'
import PetsAdocao2 from '../views/Caroline/Pets.vue'
import PetsProfile2 from '../views/Caroline/Profile.vue'
import Pets from '../views/Gabriel/Pets.vue'
import PetsProfile from '../views/Gabriel/Profile.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'main',
      component: Main
    },
    {
      path: '/home1',
      name: 'home1',
      component: Home1
    },
    {
      path: '/home2',
      name: 'home2',
      component: Home2
    },
    {
      path: '/home3',
      name: 'home3',
      component: Home3
    },
    {
      path: '/home4',
      name: 'home4',
      component: Home4
    },
    {
      path: '/pets-adocao-2',
      name: 'petsAdocao2',
      component: PetsAdocao2
    },
    {
      path: '/pets-adocao-2/:id/perfil',
      name: 'petsProfile2',
      component: PetsProfile2
    },
    {
      path: '/pets-adocao',
      name: 'Pets',
      component: Pets
    },
    {
      path: '/pets-adocao/:id/perfil',
      name: 'Profile',
      component: PetsProfile
    }
  ]
})

export default router
