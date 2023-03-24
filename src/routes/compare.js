import Vue from 'vue'

import store from '../vue/store'
import Compare from '../vue/pages/Compare.vue'

export default {
  init() {
    new Vue({
      el: '.main-content',
      components: { Compare },
      store,
      mounted() {},
      methods: {},
    })
  },

  finalize() {},
}
