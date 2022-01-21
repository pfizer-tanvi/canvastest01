<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card card-default">
          <div class="card-header">Example Using Auth API</div>
          <promise :promise="dataPromise" class="card-body">
            <template #default="{result: message}">
              {{message}}
            </template>
            <template #error>
              <p class="text-danger">Error!</p>
            </template>
          </promise>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      dataPromise: null
    };
  },
  created() {
    this.dataPromise = this.getExample();
  },
  methods: {
    async getExample() {
      const res = await axios.get('/api/example');
      return await new Promise((resolve, reject) => {
        setTimeout(() => {
          console.log(res);
          this.$snotify.success("Message Here", "Title Here");
          resolve(res.data);
        }, 2000);
      })
    }
  }
};
</script>
