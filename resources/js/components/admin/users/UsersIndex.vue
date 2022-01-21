<template>
  <section>
    <b-table striped hover :fields="fields" :items="users.data">
      <template #cell(is_super_admin)="data">
        {{ data.value | yesNo }}
      </template>
      <template #cell(created_at)="data">
        {{ data.value | datetime }}
      </template>
      <template #cell(updated_at)="data">
        {{ data.value | datetime }}
      </template>
      <template #cell(edit)="data">
        <b-button @click="edit(data.item)">edit</b-button>
      </template>
    </b-table>
  </section>
</template>

<script>
export default {
  props: ["users"],
  methods: {
    edit(user) {
      this.$emit("editButtonClicked", user);
    },
  },
  data() {
    return {
      fields: [
        "id",
        {
          key: "Name",
          sortable: true,
        },
        "email",
        "is_super_admin",
        "created_at",
        "updated_at",
        {
          key: "edit",
          label: "Edit",
        },
      ],
    };
  },
};
</script>
