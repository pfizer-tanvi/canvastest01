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
        :items="logs"
        :fields="fields"
        :filter="filter"
        @filtered="onFiltered"
        :current-page="currentPage"
        :per-page="perPage"
      />
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
  data() {
    return {
      filter: null,
      fields: [ 'Log name', 'Causer Type', 'Description' ],
      logs: [],
      currentPage: 1,
      perPage: 10,
      totalRows: 0,
    };
  },
  created(){
    this.fetchUsers();
  },
  methods: {
    fetchUsers() {
      axios.get('/api/examples/activitylog' )
        .then(({data}) => {
          this.logs = data.data;
          console.log(this.logs);
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

