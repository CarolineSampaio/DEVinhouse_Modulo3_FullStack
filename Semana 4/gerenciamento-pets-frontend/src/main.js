import './assets/main.css'

import '@mdi/font/css/materialdesignicons.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

import VCalendar from 'v-calendar'
import 'v-calendar/style.css'

import 'vuetify/styles'

import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const vuetify = createVuetify({
  components,
  directives,
  icons: {
    defaultSet: 'mdi'
  }
})

const app = createApp(App)

app.use(router).use(vuetify).use(VCalendar)

app.mount('#app')
