import Vue from 'vue'
import VueRouter from 'vue-router'

import LoginPage from '../vue/pages/account/Login.vue'
import RegisterPage from '../vue/pages/account/Register.vue'

const routes = [
  {
    path: '/',
    redirect: '/login',
  },
  {
    path: '/login',
    name: 'Login',
    component: LoginPage,
  },
  {
    path: '/register',
    name: 'Register',
    component: RegisterPage,
  },
]

export default {
  init() {
    if (document.querySelector('.checkout-login')) {
      const router = new VueRouter({
        // mode: 'history',
        routes,
      })
      // <b-message type="is-warning">{{ title }}</b-message>

      Vue.component('checkout-login', {
        template: '<div><router-view></router-view></div>',
        props: {
          title: {
            type: String,
            default: '',
          },
        },
        created() {
          this.$buefy.toast.open({
            duration: 5000,
            message: this.title,
            position: 'is-top',
            type: 'is-warning',
          })
        },
      })
      new Vue({
        el: '.checkout-login',
        // components: { App },
        router,
      })
    }
  },

  finalize() {},
}
