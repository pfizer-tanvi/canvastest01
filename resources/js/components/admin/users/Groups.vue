<template>
  <section>
    <b-table :busy="isBusy" :items="users" :fields="fields" striped>
      <template #cell(users)="data">
        <ul>
          <li v-if="data.value.length == 0">no users</li>
          <li v-else v-for="user in data.value" :key="user.email">
            {{ user.email }}
          </li>
        </ul>
      </template>
    </b-table>
  </section>
</template>

<script>
export default {
  mounted() {
    this.getUsers();
  },
  data() {
    return {
      fields: ["name", "users"],
      users: [],
      isBusy: true,
    };
  },
  methods: {
    getUsers() {
      axios
        .get("/api/manage-users/groups")
        .then((results) => {
          this.users = results.data;
          this.isBusy = false;
        })
        .catch((error) => {
          console.log(error);
          this.$bvToast.toast("Error getting users", {
            title: "Error",
            appendToast: true,
          });
        });
    },
  },
};
</script>
