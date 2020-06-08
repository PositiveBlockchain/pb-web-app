require('./bootstrap');
import Vue from 'vue';

window.Vue = require('vue');
Vue.component('app', require('./App.vue').default);

const app = new Vue({
    el: '#app'
});
