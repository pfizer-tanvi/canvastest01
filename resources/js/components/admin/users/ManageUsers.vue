<template>
  <section>
    <b-button v-b-modal.add-user class="mb-2">Add User</b-button>

    <b-modal id="add-user" hide-footer>
      <add-user @userAdded="addUser" :errors="errors"></add-user>
    </b-modal>

    <b-modal id="edit-user" hide-footer>
      <edit-user @userUpdated="updateUser" :errors="errors"></edit-user>
    </b-modal>

    <b-card no-body>
      <b-tabs card lazy>
        <b-tab title="Users" active>
          <b-card-text>
            <search-users @search="searchEvent"></search-users>

            <users-index
              :users="users"
              @editButtonClicked="editButtonClicked"
            ></users-index>

            <b-pagination
              v-model="currentPage"
              :total-rows="rows"
              :per-page="perPage"
              aria-controls="my-table"
            ></b-pagination>
          </b-card-text>
        </b-tab>
        <b-tab title="Groups">
          <b-card-text> <groups></groups> </b-card-text>
        </b-tab>
      </b-tabs>
    </b-card>
  </section>
</template>

<script>
import AddUser from "./AddUser";
import Groups from "./Groups";
import EditUser from "./EditUser";
import UsersIndex from "./UsersIndex";
import SearchUsers from "./SearchUsers";
import { mapMutations } from "vuex";
export default {
  components: {
    AddUser,
    Groups,
    EditUser,
    UsersIndex,
    AddUser,
    SearchUsers,
  },
  data() {
    return {
      errors: [],
      search: null,
      currentPage: 1,
      perPage: 10,
      rows: 0,
      users: {},
    };
  },
  computed: {
    params() {
      return {
        params: {
          page: this.currentPage,
          search: this.search,
        },
      };
    },
  },
  watch: {
    currentPage: function (to, from) {
      this.getUsers();
    },
  },
  mounted() {
    this.getUsers();
  },
  methods: {
    ...mapMutations({
      setForm: "updateForm",
    }),
    editButtonClicked(user) {
      this.setForm(user);
      this.$bvModal.show("edit-user");
    },
    updateUser(user) {
      this.$bvToast.toast("User Updated", {
        title: "Success",
        autoHideDelay: 5000,
        appendToast: true,
        variant: "success",
      });
      this.$bvModal.hide("edit-user");
      this.getUsers();
    },
    addUser(user) {
      this.$bvToast.toast("User Added", {
        title: "Success",
        autoHideDelay: 5000,
        appendToast: true,
        variant: "success",
      });
      this.$bvModal.hide("add-user");
      this.getUsers();
    },
    searchEvent(search) {
      this.search = search;
      this.currentPage = 1;
      this.getUsers();
    },
    getUsers() {
      axios
        .get(`/api/manage-users`, this.params)
        .then((results) => {
          this.users = results.data;
          this.currentPage = results.data.current_page;
          this.rows = results.data.total;
          this.perPage = results.data.per_page;
        })
        .catch((error) => {
          this.$bvToast.toast("Error getting data", {
            title: "Error",
            variant: "danger",
            solid: true,
          });
        });
    },
  },
};
</script>
