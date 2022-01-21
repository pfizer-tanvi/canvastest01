<template>
  <section>
    <b-card title="Edit User">
      <b-card-text
        ><b-form @submit="onSubmit">
          <user-form :errors="errors"></user-form>
          <b-button type="submit" variant="primary">Submit</b-button>
        </b-form>
      </b-card-text>
    </b-card>
  </section>
</template>

<script>
import UserForm from "./UserForm";
import { mapState, mapMutations } from "vuex";
export default {
  components: {
    UserForm,
  },
  props: ["errors"],
  computed: {
    ...mapState({
      form: (state) => state.manageUsers.form,
    }),
  },
  methods: {
    onSubmit(evt) {
      evt.preventDefault();
      axios
        .put(`/api/manage-users/${this.form.id}`, this.form)
        .then((results) => {
          this.$emit("userUpdated", results.data);
        })
        .catch((err) => {
          console.log(err);
          this.$bvToast.toast("Could Not Edit User", {
            title: "Error",
            autoHideDelay: 5000,
            appendToast: true,
            variant: "danger",
          });
          this.errors = err.response.data.errors;
        });
    },
  },
};
</script>
