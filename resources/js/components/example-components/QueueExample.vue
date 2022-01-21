<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
          <b-form-input v-model="message" placeholder="Message to send!"></b-form-input>
      </div>
      <div class="col-md-2">
        <b-button variant="primary" type="submit" @click="sendMessage">Send Message</b-button>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-12">
            <p>This messages has been through an SQS queue, processed and then sent to Pusher: {{response}}</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      message: null,
      response: 'nothing yet!',
    };
  },
  mounted() {
      this.listen();
  },
  methods: {
    sendMessage() {
      axios.post(`/api/send-queue-message?message=${this.message}`)
        .then(({data}) => {
          this.$bvToast.toast("Message sent successfully.", {
            title: "Sucess",
            variant: "success",
            solid: true,
          });
        })
        .catch(err => {
          console.log(err);
        });
    },
    listen() {
        Echo.private(`receive-message`).listen('RecievedExampleMessageEvent', (e) => {
            this.response = e.message;
        });
    },
  },
};
</script>
