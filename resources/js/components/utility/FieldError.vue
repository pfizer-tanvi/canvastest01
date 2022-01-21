<template>
    <div class="alert alert-danger" v-if="hasErrorsForField">
          <span v-for="(error, repo) in errors" :key="repo" v-if="repo == field">
            <ul>
                <li v-for="(item, index) in error" :key="index">
                    {{ item }}
                </li>
            </ul>
          </span>
    </div>
</template>

<script>
export default {
  props: ['errors', 'field'],
  computed: {
    hasErrorsForField() {
      return !_.isEmpty(this.errors) && this.errors[this.field] !== undefined;
    }
  }
};
</script>

<style>

</style>