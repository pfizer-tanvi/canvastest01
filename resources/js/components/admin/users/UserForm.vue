<template>
  <section>
    <b-alert show>
      <p>
        <b-icon icon="box" font-scale="4" class="pull-left mr-2"></b-icon>
        This form allows you to add a user. Since this is based on Pfizer's SSO
        you do not need to give them a password. This allows you, before they
        login, to set them up for roles and access.
        <strong
          >If you do not add them here they can just log in UNLESS you have
          configured the system to not allow non-added users. That can be done
          by clicking the "Admin" button on the user management page.</strong
        >
      </p></b-alert
    >

    <b-form-group
      id="input-group-1"
      label="Email address:"
      label-for="input-1"
      description="Only pfizer emails are allowed"
    >
      <b-form-input
        id="input-1"
        v-model="form.email"
        type="email"
        @input="onUpdate"
        required
        placeholder="Pfizer email"
      ></b-form-input>

      <b-form-text>
        <field-error :errors="errors" field="email"></field-error>
      </b-form-text>
    </b-form-group>

    <b-form-group id="input-group-4">
      <b-form-checkbox
        id="checkbox-1"
        v-model="form.is_super_admin"
        name="checkbox-1"
        @input="onUpdate"
        value="1"
        unchecked-value="0"
        >Is Admin (can add users)
      </b-form-checkbox>
    </b-form-group>
  </section>
</template>


<script>
import { mapState, mapMutations } from "vuex";
export default {
  props: ["errors"],
  methods: {
    ...mapMutations({
      setForm: "updateForm",
    }),
    onUpdate() {
      this.setForm(this.form);
    },
  },
  computed: {
    form: {
      get() {
        console.log("GET", this.$store.state.manageUsers.form);
        return this.$store.state.manageUsers.form;
      },
      set(form) {
        this.$store.commit("manageUsers.updateForm", form);
      },
    },
  },
};
</script>
