import { config } from "@vue/test-utils"
config.mocks.$t = key => key;

import Vue from 'vue';

import $ from 'jquery';
global.$ = global.jQuery = $;

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
Vue.component('font-awesome-icon', FontAwesomeIcon);

import { library } from "@fortawesome/fontawesome-svg-core";
import {
   faBars
} from "@fortawesome/free-solid-svg-icons";
library.add(
   faBars
);