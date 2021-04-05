require('./bootstrap');
import 'leaflet/dist/leaflet.css';

import Vue from 'vue';
import {LMap, LTileLayer, LMarker} from 'vue2-leaflet';
require('./leaflet-providers');

window.Vue = require('vue');
Vue.component('app', require('./App.vue').default);
Vue.component('projects-active-list', require('./components/projects/ProjectsActiveListComponent').default);
Vue.component('projects-all-list', require('./components/projects/ProjectsAllListComponent').default);
Vue.component('sdg-goals', require('./components/sdgs/SdgGoalsComponent').default);
Vue.component('project-map', require('./components/projects/ProjectMapsComponent').default);
Vue.component('card-modal', require('./components/helpers/CardModal.vue').default);
Vue.component('l-map', LMap);
Vue.component('l-tile-layer', LTileLayer);
Vue.component('l-marker', LMarker);


var eventHub = window.eventHub = new Vue();

const app = new Vue({
    el: '#app'
});
