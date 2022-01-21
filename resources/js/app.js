/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window._ = require("lodash");
window.axios = require("axios");

import Vue from "vue";

import "core-js/stable";

import "bootstrap-vue/dist/bootstrap-vue.css";
require("./bootstrap");
import { BootstrapVue, BootstrapVueIcons } from "bootstrap-vue";
Vue.use(BootstrapVueIcons);
Vue.use(BootstrapVue);

import VueI18n from "vue-i18n";
Vue.use(VueI18n);

import VueRouter from "vue-router";
import { routes } from "./routes";
Vue.use(VueRouter);

import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
Vue.component("font-awesome-icon", FontAwesomeIcon);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Common Utilities
Vue.component("loading", require("./components/utility/Loading.vue").default);
Vue.component("promise", require("./components/utility/Promise.vue").default);
Vue.component(
  "field-error",
  require("./components/utility/FieldError.vue").default
);

// Examples (You can delete these once your app is ready)
Vue.component(
  "auth-example",
  require("./components/example-components/AuthExample.vue").default
);
Vue.component(
  "testing",
  require("./components/example-components/Testing.vue").default
);
Vue.component(
  "show-log-activities",
  require("./components/example-components/ShowLogActivities.vue").default
);
Vue.component(
  "upload-show-files",
  require("./components/example-components/UploadAndShowFiles.vue").default
);
Vue.component(
  "queue-example",
  require("./components/example-components/QueueExample.vue").default
);

//Manage Users
Vue.component(
  "manage-users-root",
  require("./components/admin/users/ManageUsers.vue").default
);
Vue.component("groups", require("./components/admin/users/Groups.vue").default);

// Views
Vue.component(
  "support-request",
  require("./components/support/Request.vue").default
);

import store from "./store";

const app = new Vue({
  i18n: new VueI18n({ locale: window.locale }),
  el: "#app",
  store,
  router: new VueRouter({ mode: "history", routes })
});
