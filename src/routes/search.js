import Vue from 'vue'
import VueRouter from 'vue-router'
import Search from '../vue/pages/Search.vue'
import store from '../vue/store'

export default {
  init() {
    // const routes = [{ path: '/', component: Search }]

    const router = new VueRouter({
      mode: 'history',
      routes: [],
    })

    Vue.use(VueRouter)

    new Vue({
      el: '.main-content',
      components: { Search },
      store,
      router,
      mounted() {},
      methods: {},
    })
  },

  finalize() {},
}
