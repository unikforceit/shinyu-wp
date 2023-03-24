import Vue from 'vue'
import VueRouter from 'vue-router'

import store from '../vue/store'
import guest from '../vue/middleware/guest'
import auth from '../vue/middleware/auth'

import App from '../vue/pages/account/App.vue'
import HomePage from '../vue/pages/account/Home.vue'
import EditPage from '../vue/pages/account/Edit.vue'
import OrderPage from '../vue/pages/account/Order.vue'
import LoginPage from '../vue/pages/account/Login.vue'
import LostPassword from '../vue/pages/account/LostPassword.vue'
import RegisterPage from '../vue/pages/account/Register.vue'
import Property from '../vue/pages/account/Property.vue'
import PostProperty from '../vue/pages/account/PostProperty.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: HomePage,
    meta: {
      middleware: [auth],
    },
  },
  {
    path: '/edit',
    name: 'Edit',
    component: EditPage,
    meta: {
      middleware: [auth],
    },
  },
  {
    path: '/order',
    name: 'Order',
    component: OrderPage,
    meta: {
      middleware: [auth],
    },
  },
  {
    path: '/property',
    name: 'Property',
    component: Property,
    meta: {
      middleware: [auth],
    },
  },
  {
    path: '/post-property',
    name: 'PostProperty',
    component: PostProperty,
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
    path: '/lost-password',
    name: 'LostPassword',
    component: LostPassword,
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
      components: { App },
      store,
      router,
    })
  },

  finalize() {},
}
