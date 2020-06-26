require('./bootstrap');
import Vue from 'vue';

window.Vue = require('vue');
Vue.component('app', require('./App.vue').default);
Vue.component('projects-list', require('./components/projects/ProjectsListComponent').default);
Vue.component('sdg-list', require('./components/sdgs/SdgGoalsListComponent').default);
Vue.component('card-modal', require('./components/helpers/CardModal.vue').default);


var eventHub = window.eventHub = new Vue();

const app = new Vue({
    el: '#app'
});
