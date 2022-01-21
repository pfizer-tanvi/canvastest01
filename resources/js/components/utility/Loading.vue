<template functional>
  <div class="m-4 alert alert-info" v-on="listeners" v-bind="data.attrs">
    <span class="display-3 text-muted loading">
      <i class="fa fa-gears fa-spin"></i> Loading...
      <slot/>
    </span>
  </div>
</template>

<style lang="scss">
.loading {
  font-size: 1.5rem;
}
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>
