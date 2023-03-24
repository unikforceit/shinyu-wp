import Vue from 'vue'
import Vuex from 'vuex'
import VuexPersistence from 'vuex-persist'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    compareItems: [],
    loading: false,
    advancedSearch: false,
    modal: 'login',
    user: SHINYU.user.data,
    // loggedIn: SHINYU.USE,
  },

  getters: {
    user: (state) => {
      return state.user
    },
  },

  mutations: {
    SET_COMPARE(state, data) {
      state.compareItems = data
    },
    SET_LOADING(state, data) {
      state.loading = data
    },
    SET_SEARCH_ADVANCED(state, data) {
      state.advancedSearch = data
    },
    SET_MODAL(state, data) {
      state.modal = data
    },
    SET_USER(state, data) {
      state.user = data
    },
    // SET_LOGGED_IN(state, data) {
    //   state.loggedIn = data
    // },
  },
  plugins: [new VuexPersistence().plugin],
})

export default store
