<template>
  <div>
    <slot v-if="result" :result="result"/>
    <slot name="error" v-else-if="error" :error="error"/>
    <slot name="pending" v-else-if="promise && !noLoading">
      <loading/>
    </slot>
    <slot name="noPromise" v-if="!promise"/>
  </div>
</template>

<script>
export default {
  props: {
    pending: {type: Boolean, default: false},
    promise: {type: Promise},
    noLoading: {type: Boolean, default: false}
  },
  data() {
    return {
      result: null,
      error: null
    }
  },
  created() {
    this.handlePromise(this.promise);
  },
  watch: {
    promise(val) {
      this.handlePromise(val);
    }
  },
  methods: {
    handlePromise(promise) {
      const vm = this;
      vm.result = null;
      vm.error = null;
      if(promise) {
        vm.$emit('update:pending', true);
        promise
          .then(result => {
            vm.result = result || true;
            vm.$emit('update:pending', false);
          })
          .catch(error => {
            console.error(error);
            vm.error = error || true;
            vm.$emit('update:pending', false);
          });
      }
    }
  }
}
</script>
