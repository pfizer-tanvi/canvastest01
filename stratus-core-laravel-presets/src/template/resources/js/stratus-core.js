import Vue from 'vue';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import jQuery from 'jquery';

import 'core-js/stable';
import plugins from './plugins';
import './components/global';

Vue.use(plugins);

window.$ = window.jQuery = jQuery;

window.Echo = new Echo({
  broadcaster: window.Laravel.env == 'testing' ? 'log' : 'pusher',
  key: window.Laravel.pusher_key,
  cluster: window.Laravel.pusher_cluster,
  encrypted: true,
});
