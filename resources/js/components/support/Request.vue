<template>
  <b-form @submit="onSubmit">
    <b-form-group
      id="title-group"
      label="Subject of issue"
      label-for="title"
      description="This will help get our attention"
    >
      <b-form-input
        id="title"
        v-model="form.title"
        placeholder="Subject of issue"
      ></b-form-input>
    </b-form-group>

    <b-form-group
      v-show="featureFlagType"
      id="type-group"
      label="Type of Request"
      label-for="type"
      description="This will help us send it to the right people"
    >
      <b-form-select v-model="form.type" :options="options"></b-form-select>
    </b-form-group>

    <b-form-group
      id="desc-group"
      label="Describe the issue"
      label-for="description"
      description="Give us some details, where, what, how to recreate the issue"
    >
      <b-form-textarea
        id="description"
        v-model="form.description"
        placeholder="What is the issue? How can we recreate it"
        rows="3"
        max-rows="6"
      ></b-form-textarea>
    </b-form-group>
    <b-button type="submit" variant="primary">Submit</b-button>
  </b-form>
</template>

<script>
export default {
  computed: {
    featureFlagType() {
      return window.Laravel.feature_flags["support-request-type"] == true;
    },
  },
  methods: {
    onSubmit(event) {
      event.preventDefault();
      axios
        .post("/api/support-requests", this.form)
        .then((response) => {
          this.$bvToast.toast(
            `Your ticket has been submitted the id is ${response.data.id}`,
            {
              title: "Success",
              variant: "primary",
              solid: true,
            }
          );
          this.form = {};
        })
        .catch((error) => {
          this.$bvToast.toast(
            "Error making your ticket please try again later",
            {
              title: "Error",
              variant: "danger",
              solid: true,
            }
          );
        });
    },
  },
  data() {
    return {
      options: [
        { value: "feature", text: "Feature Request" },
        { value: "bug", text: "Bug Report" },
        { value: "help", text: "Need Help!" },
      ],
      form: {
        type: "feature",
      },
    };
  },
};
</script>
