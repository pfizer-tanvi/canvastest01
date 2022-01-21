import store from '@/store';
import router from '@/router';

import i18n from './i18n';

export default {
  install(Vue) {
    Vue.mixin({ store, router, i18n });
  },
};
