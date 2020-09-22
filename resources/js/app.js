require('./bootstrap');
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import  Axios from 'axios'

import Vue from 'vue';
import VueLodash from 'vue-lodash';
import lodash from 'lodash';

// Vue.component('subcategori-component', require('./components/SubcategoriComponent.vue'));

window.Vue = require('vue');
Vue.use(VueRouter,VueAxios,Axios,VueLodash);

const app = new Vue({
  el: '#app'
});

                