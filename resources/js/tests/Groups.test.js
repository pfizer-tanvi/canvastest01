import { mount, shallowMount, createLocalVue } from "@vue/test-utils";
import Groups from "@/components/admin/users/Groups.vue";
import { BTable, BPagination } from 'bootstrap-vue';
const localVue = createLocalVue();
localVue.use(require('bootstrap-vue'));
import groups from "@/tests/fixtures/groups.js";
import axios from "axios";
let MockAdapter = require("axios-mock-adapter");
let axiosMock = new MockAdapter(axios);
window.axios = axios;


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

describe('Groups UI', () => {
  let wrapper
  let store

  beforeEach(() => {
    axiosMock.onGet("/api/manage-users/groups").reply(200, groups);
    store = actions;
    wrapper = mount(Groups, {
      localVue, store, router, mapGetters
    });
  })

  afterEach(() => {
    wrapper.destroy();
  });

  it("Is a Vue instance", () => {
    expect(wrapper.isVueInstance).toBeTruthy();
  })

  it("Prove we output the table", async () => {

    await wrapper.vm.$nextTick();

    expect(await wrapper
      .findComponent(BTable)
      .find('tbody')
      .findAll('tr')
      .length
    ).toBe(5);
  })


  it("Shows no users as needed", async () => {

    await wrapper.vm.$nextTick();

    expect(await wrapper
      .findComponent(BTable)
      .find('tbody')
      .findAll('tr')
      .at(0)
      .findAll('td')
      .at(1)
      .text()
    ).toBe("no users");

    expect(await wrapper
      .findComponent(BTable)
      .find('tbody')
      .findAll('tr')
      .at(2)
      .findAll('td')
      .at(1)
      .text()
    ).toBe("vhomenick@example.org");
  })
});
