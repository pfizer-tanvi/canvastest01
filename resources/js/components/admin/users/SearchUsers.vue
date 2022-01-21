<template>
  <section>
    <b-form-input
      :autofocus="true"
      type="text"
      v-model="searchInput"
      @input="searchEvent"
      placeholder="Search Users"
    ></b-form-input>
    Searching for {{ searchInput }}
  </section>
</template>

<script>
export default {
  methods: {
    searchEvent(search) {
      this.$emit("search", search);
    },
  },
  data() {
    return {
      searchInput: null,
    };
  },
};
</script>
