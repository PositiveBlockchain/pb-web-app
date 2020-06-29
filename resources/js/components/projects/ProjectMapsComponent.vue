<template>
    <div class="leaflet-map relative" id="map">
        <l-map ref="projectMap" @ready="assignMapObject">
            <l-tile-layer url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"/>
            <l-marker class="min-h-full" v-if="loaded" v-for="(project, index) in projects"
                      :lat-lng="getLatLng(project)" :key="index">
                <l-icon
                    icon-url="/storage/icons/marker-icon.png">
                </l-icon>
                <l-popup>
                    <h2 class="font-bold">{{project.title}}</h2>
                    <address>{{project.fields.gAddress}}</address>
                    <img v-bind:alt="'Project logo ' + project.title"
                         :src="project.fields.business_logo"
                         class="map-project-logo"/>
                </l-popup>
            </l-marker>
        </l-map>
        <div v-if="!markersLoaded" class="flex justify-center absolute inset-x-0 top-0">
            <spinner></spinner>
        </div>
    </div>
</template>

<script>
    import Spinner from "../helpers/Spinner";
    import {LPopup, LIcon} from 'vue2-leaflet'

    export default {
        name: "ProjectMapsComponent",
        components: {
            Spinner,
            LPopup,
            LIcon
        },
        data() {
            return {
                loaded: false,
                map: null,
                projects: [],
                tileProvider: {
                    maxZoom: 19,
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                },
            }
        },
        computed: {
            markersLoaded: function () {
                if (this.loaded) {
                    return this.projects.length === this.map._layers.length;
                }
            }
        },
        created() {
            this.getProjectLocations();
        },
        mounted() {
            this.$nextTick(() => {
            });
        },
        methods: {
            getLatLng(project) {
                if (project.fields.hasOwnProperty('latitude') && project.fields.hasOwnProperty('longitude')) {
                    return [parseFloat(project.fields.latitude), parseFloat(project.fields.longitude)];
                } else {
                    console.error('no valid lat long availabe');
                    return false;
                }
            },
            assignMapObject() {
                this.map = this.$refs.projectMap.mapObject
                this.map.setView([48.864716, 2.349014], 3)
            },
            getProjectLocations: async function () {
                this.loaded = false;
                try {
                    const response = await axios.get('api/v1/project-locations?limit=500');
                    this.projects = response.data.data;
                    this.loaded = true;
                } catch (e) {
                    console.error(e);
                }
            }
        }
    }
</script>

<style scoped>
    #map {
        height: 25vh;
        min-height: 600px;
    }

    .map-project-logo {
        width: 100px;
    }
</style>
