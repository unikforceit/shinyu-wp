import Vue from 'vue'
import Vuex from 'vuex'
import VuexPersistence from 'vuex-persist'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    compare: 1,
  },
  mutations: {
    SET_COMPARE(state, data) {
      console.log(state.compare)
      state.compare = data
    },
  },
  plugins: [new VuexPersistence().plugin],
})

export default store
