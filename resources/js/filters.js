import Vue from 'vue';

var numeral = require("numeral");
var moment = require("moment");

/**
 * Format the given date as a timestamp.
 */
Vue.filter('datetime', (value) => {
  return moment.utc(value).local().format('MMMM Do, YYYY h:mm A');
});

/**
 * Format the given date into a relative time.
 */
Vue.filter('relative', (value) => {
  return moment.utc(value).local().locale('en-short').fromNow();
});

/**
 * Convert the first character to upper case.
 *
 * Source: https://github.com/vuejs/vue/blob/1.0/src/filters/index.js#L37
 */
Vue.filter('capitalize', (value) => {
  if (!value && value !== 0) {
    return '';
  }

  return value.toString().charAt(0).toUpperCase() + value.slice(1);
});

Vue.filter('capitalizeAll', (value) => {
  if (!value && value !== 0) {
    return '';
  }

  return value.replace(/\b\w/g, function (l) { return l.toUpperCase() });
});

Vue.filter('line_breaks', (value) => {
  if (value == undefined) {
    return '';
  }
  return value.replace('\n', '<br>');
});

/**
 * Format the given money value.
 *
 * Source: https://github.com/vuejs/vue/blob/1.0/src/filters/index.js#L70
 */
Vue.filter('currency', (value, float = true) => {
  let format = "$0,0.00"
  if (!float) {
    format = "$0,0"
  }
  return numeral(value).format(format);
});

Vue.filter('formatDate', function (value, args = 'MM-DD-YYYY') {
  if (value) {
    return moment(String(value)).format(args);
  }
});

Vue.filter('capitalize', function (value) {
  if (!value) {
    return '';
  }
  value = value.toString();
  return value.charAt(0).toUpperCase() + value.slice(1);
});

Vue.filter('yesNo', function (value) {
  if (value) {
    return value == 1 ? 'Yes' : 'No';
  }
  return 'No';
});

Vue.filter('truncate', function (text, stop, clamp) {
  if (typeof stop == 'undefined') {
    stop = 30;
  }
  return text.slice(0, stop) + (stop < text.length ? clamp || '...' : '');
});

Vue.filter('strLimit', (value, length = 25, end = '...') => {
  if (String(value).length <= length) {
    return value;
  }
  return `${String(value).substr(0, length)} ${end}`;
});

Vue.filter("integer", function (value) {
  return Number.parseInt(value);
});

Vue.filter("formatNumber", function (value) {
  return numeral(value).format("0,0");
});

