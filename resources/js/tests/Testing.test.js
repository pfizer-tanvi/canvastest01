import { shallowMount, createLocalVue } from "@vue/test-utils";
import Testing from "@/components/example-components/Testing.vue";
const localVue = createLocalVue();
localVue.use(require('bootstrap-vue'));

import Vuex from 'vuex';
localVue.use(Vuex);

import actions from '../store';
import mapGetters from "vuex";

import VueRouter from "vue-router";
localVue.use(VueRouter);
const router = new VueRouter();
const spy = jest.fn();

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
localVue.component('font-awesome-icon', FontAwesomeIcon);

describe('Testing.vue', () => {
  let wrapper
  let store

  beforeEach(() => {
    store = actions;
    wrapper = shallowMount(Testing, {
      localVue, store, router, mapGetters
    });
  })

  afterEach(() => {
    wrapper.destroy();
  });

  it("Is a Vue instance", () => {
    expect(wrapper.isVueInstance).toBeTruthy();
  })
});
