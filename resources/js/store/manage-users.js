const state = () => ({
  form: {
    id: null,
    email: null,
    is_super_admin: 0,
  },
});

const getters = {
  form: state => {
    return state.form;
  },
}

const mutations = {
  updateForm(state, form) {
    state.form = form
  }
}

export default {
  state,
  getters,
  mutations
}
