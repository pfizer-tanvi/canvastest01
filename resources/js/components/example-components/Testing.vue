<template>
  <section></section>
</template>

<script>
export default {
  created() {
    setTimeout(() => {
      this.$store.commit("loading", false);
    }, 3000);
  },
};
</script>
