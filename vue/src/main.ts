import { createApp } from 'vue'
import { pinia } from '@/stores'

import App from './App.vue'
import './assets/main.css'
import './style.css'

import { components } from './components'

import router from './router'
import http from './utilities/http'

const app = createApp(App)

app.use(http, { router })
app.use(router)
app.use(components)
app.use(pinia)

app.mount('#app')