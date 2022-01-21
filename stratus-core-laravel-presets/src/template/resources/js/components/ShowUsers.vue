<template>
  <div>
    <b-container fluid>
      <b-row>
        <b-col md="6" class="my-1">
          <b-form-group horizontal label="Filter" class="mb-0">
            <b-input-group>
              <b-form-input v-model="filter" placeholder="Type to Search" />
              <b-input-group-append>
                <b-btn :disabled="!filter" @click="filter = ''">Clear</b-btn>
              </b-input-group-append>
            </b-input-group>
          </b-form-group>
        </b-col>
      </b-row>

      <b-table
        show-empty
        stacked="md"
        :items="users"
        :fields="fields"
        :filter="filter"
        :current-page="currentPage"
        :per-page="perPage"
        @filtered="onFiltered"
      >
        <template #is_super_admin="row">
          <i v-if="row.item.is_super_admin === 1" class="fa fa-check" aria-hidden="true"></i>
          <i v-if="row.item.is_super_admin === 0" class="fa fa-close" aria-hidden="true"></i>
        </template>
        <template #Options="row">
          <b-form-group horizontal class="mb-0">
            <b-input-group>
              <b-link size="md" class="btn btn-warning " v-bind:href="'users/' + row.item.id + '/edit'">Edit</b-link>
              &nbsp;
              <form id="logout-form"  v-bind:action="'users/' + row.item.id " method="POST" >
                <input name="_method" type="hidden" value="DELETE">
                <input type="hidden" name="_token" :value="csrf">
                <b-button size="md" type="submit" onclick="return confirm('Delete? Are you sure?');">
                  Delete
                </b-button>
              </form>
            </b-input-group>
          </b-form-group>
        </template>
      </b-table>

      <b-row>
        <b-col md="6" class="my-1">
          <b-pagination :total-rows="totalRows" :per-page="perPage" v-model="currentPage" class="my-0" />
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>

<script>
export default {
  props: ['csrf'],
  data() {
    return {
      filter: null,
      fields: [ 'name', 'email', 'is_super_admin', 'Options' ],
      users: [],
      currentPage: 1,
      perPage: 2,
      totalRows: 0,
    };
  },
  created(){
    this.fetchUsers();
  },
  methods: {
    fetchUsers() {
      axios.get('/api/users/')
        .then(({data}) => {
          this.users = data.data;
        })
        .catch(err => {
          console.log(err);
        });
    },
    onFiltered(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalRows = filteredItems.length
      this.currentPage = 1
    }
  }
};
</script>