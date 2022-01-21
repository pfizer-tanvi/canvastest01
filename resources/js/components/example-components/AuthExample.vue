<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card card-default">
          <div class="card-header">Example Using Auth API</div>
          <promise :promise="dataPromise" class="card-body">
            <template #default="{ result: message }">
              {{ message }}
            </template>
            <template #error>
              <p class="text-danger">Error!</p>
            </template>
          </promise>
        </div>
        <b-button variant="info" @click="makeToast('info')" class="mt-2"
          >Show Toaster</b-button
        >
        <b-link
          href="https://bootstrap-vue.org/docs/components"
          class="pull-right"
          target="_blank"
          >Learn more about our components
          <b-icon icon="emoji-sunglasses"></b-icon
        ></b-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      dataPromise: null,
    };
  },
  created() {
    this.dataPromise = this.getExample();
  },
  methods: {
    makeToast(variant = null) {
      this.$bvToast.toast("Toast body content", {
        title: `Variant ${variant || "default"}`,
        variant: variant,
        solid: true,
      });
    },
    async getExample() {
      const res = await axios.get("/api/example");
      return await new Promise((resolve, reject) => {
        setTimeout(() => {
          console.log(res);
          this.$bvToast.toast("Message here", {
            title: "BootstrapVue Toast",
            autoHideDelay: 5000,
            appendToast: true,
            variant: "info",
          });
          resolve(res.data);
        }, 2000);
      });
    },
  },
};
</script>
