import Vue from 'vue';
import VueI18n from 'vue-i18n';

Vue.use(VueI18n);

export default new VueI18n({
  locale: window.locale,
  messages: require('@kirschbaum-development/laravel-translations-loader/php!@kirschbaum-development/laravel-translations-loader')
    .default,
});
