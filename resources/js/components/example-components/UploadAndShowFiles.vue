<template>
  <div>
    <b-alert :show="showAlert" dismissSecs=10, :variant="alertVariant">{{alertMessage}}</b-alert>
    <b-container fluid>
      <b-row>
        <b-form-group >
          <b-form-file v-model="upload_file" :state="Boolean(upload_file)" ref="fileinput" placeholder="Choose a file..."/>
          <div class="mt-3">Selected file: {{upload_file && upload_file.name}}</div>
          <br>
          <b-button variant="primary" type="submit" @click="fileChosen">Submit</b-button>
        </b-form-group >
      </b-row>

      <b-row>
        <b-form-group >
          <h1 class="my-4">All files</h1> &nbsp;
          <b-button variant="primary" type="submit" @click="listFiles">Refresh</b-button>
        </b-form-group>
      </b-row>

      <b-row>
        <b-table
          show-empty
          stacked="md"
          :items="files"
          :fields="fields"
          :filter="filter"
          @filtered="onFiltered"
          :current-page="currentPage"
          :per-page="perPage"
        >
          <template #Path="row">
            <span v-html="row.item"></span>
          </template>
          <template #Download="row">
            <a :href="'download/file?file_name=' + row.item" v-text="row.item"></a>
          </template>
          <template #Option="row">
              <b-button type="submit"  @click="deleteFile(row.item)" variant="primary">Delete</b-button>
          </template>
        </b-table>
        <b-row>
          <b-col md="6" class="my-1">
            <b-pagination :total-rows="totalRows" :per-page="perPage" v-model="currentPage" class="my-0" />
          </b-col>
        </b-row>
      </b-row>
    </b-container>
  </div>
</template>
<script>
export default {
  data() {
    return {
      upload_file: null,
      filter: null,
      fields: [ 'Path', 'Download', 'Option' ],
      files: [],
      currentPage: 1,
      perPage: 10,
      totalRows: 0,
      showAlert: false,
      alertVariant: "success",
      alertMessage: "File uploaded successfully",
    };
  },
  created(){
    this.listFiles();
  },
  methods: {
    fileChosen() {
      const data = new FormData();
      data.append('uploaded_file', this.upload_file);

      axios.post('/api/examples/store/file', data)
        .then(results => {
          this.listFiles();
          this.alertVariant = "success";
          this.alertMessage = "File uploaded successfully";
          this.showAlert = true;
          this.clearFiles();
        })
        .catch(err => {
          this.alertVariant = "danger";
          this.alertMessage = "Error while uploading file";
          this.showAlert = true;
          console.log(err);
        });
    },
    clearFiles () {
      this.$refs.fileinput.reset();
    },
    listFiles() {
      axios.get('/api/examples/list/file')
        .then(results => {
          this.files = results.data.data;
          console.log(this.files);
        })
        .catch(err => {
          console.log(err);
        });
    },
    deleteFile(fileName){
      axios.delete('/api/examples/delete/file',  {params: {'file_name': fileName}})
        .then(results => {
          this.listFiles();
          this.alertVariant = "success";
          this.alertMessage = "File deleted successfully";
          this.showAlert = true;
        })
        .catch(err => {
          this.alertVariant = "danger";
          this.alertMessage = "Error while deleting file";
          this.showAlert = true;
          console.log(err);
        });
    },
    onFiltered (filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalRows = filteredItems.length
      this.currentPage = 1
    }
  }
};
</script>

