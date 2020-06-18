require('./bootstrap');
import Vue from 'vue';

window.Vue = require('vue');
Vue.component('app', require('./App.vue').default);

var eventHub = window.eventHub = new Vue();

const app = new Vue({
    el: '#app'
});
