import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import SNotify from 'vue-snotify';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import 'vue-snotify/styles/material.css';

Vue.use(BootstrapVue);

Vue.use(SNotify);

Vue.component('font-awesome-icon', FontAwesomeIcon);

// Common Utilities
Vue.component('loading', require('./utility/Loading.vue').default);
Vue.component('promise', require('./utility/Promise.vue').default);

// Examples (You can delete these once your app is ready)
Vue.component('auth-example', require('./example-components/AuthExample.vue').default);
Vue.component('testing', require('./example-components/Testing.vue').default);
Vue.component('show-log-activities', require('./example-components/ShowLogActivities.vue').default);
Vue.component('upload-show-files', require('./example-components/UploadAndShowFiles.vue').default);

// Views
Vue.component('user-form', require('./UserForm.vue').default);
Vue.component('show-users', require('./ShowUsers.vue').default);
