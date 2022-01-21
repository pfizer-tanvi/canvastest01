import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
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
    },
  },
});
