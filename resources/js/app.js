require('./bootstrap');
import Vue from 'vue';

window.Vue = require('vue');
Vue.component('app', require('./App.vue').default);
Vue.component('projects-list', require('./components/projects/ProjectsListComponent').default);

var eventHub = window.eventHub = new Vue();

const app = new Vue({
    el: '#app'
});
