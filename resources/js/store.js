import Vue from 'vue'
import Vuex from 'vuex'
import manageUsers from './store/manage-users.js'
Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store(
  {
    modules: {
      manageUsers
    },
    state: {
      loading: true,
    },
    getters: {
      loading: state => {
        return state.loading;
      },
    },
    mutations: {
      loading(state, loading) {
        state.loading = loading;
      }
    }
  }
);
