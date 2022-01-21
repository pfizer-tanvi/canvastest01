<template>
  <b-container>
    <media-upload @uploaded="fetchMediaFiles" />
    <b-row align-h="center">
      <b-col md="8">
        <header class="d-flex justify-content-between align-items-center mb-3">
          <h1>Media files</h1>
          <div>
            <b-button variant="outline-primary" v-b-modal.updload-modal>
              <b-icon icon="upload" font-scale="0.8"></b-icon>
              Upload File
            </b-button>
          </div>
        </header>

        <b-row v-if="isLoading">
          <b-col md="6" v-for="i in 4" :key="i">
            <b-skeleton-img fluid></b-skeleton-img>
          </b-col>
        </b-row>

        <b-card v-else-if="media.length === 0">
          <b-card-text class="text-center">
            <b-icon icon="card-image" font-scale="7.5" variant="secondary"></b-icon>
            <p>There are no media items yet</p>
            <b-button variant="outline-primary" v-b-modal.updload-modal>
              <b-icon icon="upload" font-scale="0.8"></b-icon>
              Upload File
            </b-button>
          </b-card-text>
        </b-card>

        <b-row v-else>
          <b-col md="6" v-for="file in media" :key="media.id">
            <b-img-lazy thumbnail fluid :src="file.url" />
          </b-col>
        </b-row>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
  import MediaUpload from './upload';

  export default {
    components: { MediaUpload },
    data() {
      return {
        isLoading: false,
        media: [],
      };
    },
    created() {
      this.fetchMediaFiles();
    },
    methods: {
      fetchMediaFiles() {
        this.isLoading = true;
        window.axios
          .get('/media')
          .then(({ data: response }) => {
            this.media = response?.data || [];
          })
          .catch((e) => {
            console.log(e);
            this.$root.$bvToast.toast('Something went wrong while fetching media files', {
              title: 'Opps!!',
              variant: 'warning',
              solid: true,
            });
          })
          .finally(() => {
            this.isLoading = false;
          });
      },
    },
  };
</script>
