import { createApp } from 'vue'
import App from './App.vue'
import { createRouter, createWebHistory } from 'vue-router'
import './index.css'
import store from './store'
import MainPage from './views/MainPage.vue'
import authPage from './views/authPage.vue'
import registerPage from './views/registerPage.vue'
import profilePage from './views/profilePage.vue'
const router = createRouter({
  routes: [
    {
      path: '/',
      component: MainPage
    },
    {
      path: '/authPage',
      component: authPage
    },
    {
      path: '/registerPage',
      component: registerPage
    },
    {
      path: '/profilePage',
      component: profilePage
    }
  ],
  history: createWebHistory()
})

const app = createApp(App)

app.use(router)
app.mount('#app')
app.use(store)
