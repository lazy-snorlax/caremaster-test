import { createApp } from 'vue'
import './style.css'
import App from './App.vue'

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