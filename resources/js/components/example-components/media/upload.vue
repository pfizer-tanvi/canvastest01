<template>
  <section class="text-center" v-bind="$attrs">
    <b-modal
      @ok.prevent="handleUpload"
      no-close-on-esc
      no-close-on-backdrop
      ref="modal"
      id="updload-modal"
      title="Upload file"
      centered
      :ok-disabled="!file"
      ok-title="Upload Image"
      :busy="isUploading"
    >
      <b-form-file
        accept="image/*"
        v-model="file"
        label="Image"
        placeholder="Upload image"
        :state="isValid"
      ></b-form-file>
      <b-form-invalid-feedback :state="isValid">
        {{ error || 'Somethinf went wrong' }}
      </b-form-invalid-feedback>
    </b-modal>
  </section>
</template>
<script>
  export default {
    data() {
      return {
        file: null,
        isUploading: false,
        error: false,
      };
    },

    computed: {
      isValid() {
        return this.error ? false : null;
      },
    },

    methods: {
      close() {
        this.$refs.modal.hide();
      },
      handleUpload(e) {
        const data = new FormData();

        data.append('file', this.file);

        this.isUploading = true;

        this.error = null;

        window.axios
          .post('/media', data, {
            headers: {
              'Content-Type': 'multipart/form-data',
            },
          })
          .then((media) => {
            this.close();
            this.$emit('uploaded', media);
          })
          .catch(({ response }) => {
            const data = response?.data || {};
            const error =
              data?.errors?.file?.[0] ||
              data?.message ||
              'Something went wrong while uploading file';

            this.error = error;
          })
          .finally(() => {
            this.isUploading = false;
          });
      },
    },
  };
</script>
