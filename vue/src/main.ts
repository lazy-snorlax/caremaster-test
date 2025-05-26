import { createApp } from 'vue'
import App from './App.vue'

import './assets/main.css'
import './style.css'

import { components } from './components'
import { pinia } from '@/stores'

import router from './router'
import http from './utilities/http'

const app = createApp(App)

app.use(http, { router })
app.use(pinia)
app.use(router)
app.use(components)

app.mount('#app')