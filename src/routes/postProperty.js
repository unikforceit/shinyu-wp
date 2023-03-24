import Vue from 'vue'
import VueRouter from 'vue-router'

import guest from '../vue/middleware/guest'
import auth from '../vue/middleware/auth'

import LoginPage from '../vue/pages/account/Login.vue'
import RegisterPage from '../vue/pages/account/Register.vue'
import Home from '../vue/pages/account/PostProperty.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
    meta: {
      middleware: [auth],
    },
  },
  {
    path: '/login',
    name: 'Login',
    component: LoginPage,
    meta: {
      middleware: [guest],
    },
  },
  {
    path: '/register',
    name: 'Register',
    component: RegisterPage,
    meta: {
      middleware: [guest],
    },
  },
]

export default {
  init() {
    const router = new VueRouter({
      // mode: 'history',
      routes,
    })

    router.beforeEach((to, from, next) => {
      if (!to.meta.middleware) {
        return next()
      }
      const { middleware } = to.meta

      const context = {
        to,
        from,
        next,
      }
      return middleware[0]({
        ...context,
      })
    })
    new Vue({
      el: '.main-content',
      router,
    })
  },

  finalize() {},
}
