<template>
    <div class="projects-map">
        <div class="grid md:grid-cols-3 sm:grid-cols-1 gap-2">
            <div class="leaflet-map md:col-span-2" id="map">
                <l-map ref="projectMap" @ready="assignMapObject">
                    <l-tile-layer url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"/>
                    <l-marker class="min-h-full" v-if="loaded" v-for="(project, index) in projectsFilteredByCategory"
                              :lat-lng="getLatLng(project)" :key="index">
                        <l-icon
                            icon-url="/storage/icons/marker-icon.png">
                        </l-icon>
                        <l-popup>
                            <img v-bind:alt="'Project logo ' + project.title"
                                 :src="project.fields.business_logo"
                                 class="map-project-logo float-left mr-5 p-2"/>

                            <h2 class="font-bold">{{project.title}}</h2>
                            <address class="mb-4">{{project.fields.gAddress}}</address>
                            <p v-if="isEmpty(project.fields.short_description)" class="text-gray-700 mt-4">
                                {{getAbstract(project.fields.short_description)}}
                            </p>
                            <p v-else class="text-gray-700 content mt-4">
                                {{getAbstract(project.content)}}
                            </p>

                            <a :href="project.permalink"
                               class="text-green-500 hover:text-green-800"
                               target="_blank">learn more</a>
                        </l-popup>
                    </l-marker>
                </l-map>
            </div>

            <div class="md:col-span-1 sm:col-span-3 categories mb-5">
                <map-project-category-filter-component :categories="getCategories"
                                                       :selected-categories="selectedCategories">

                </map-project-category-filter-component>
            </div>
            <div class="md:col-span-2 sm:col-span-3">
                <div v-if="loaded" class="grid md:grid-cols-3 sm:grid-cols-1 gap-2 mt-5">
                    <div class="max-w-sm rounded overflow-hidden relative shadow-lg">
                        <div class="px-6 py-4 text-center">
                            <h3 class="font-bold mb-3 text-gray-600">Total projects with location data</h3>
                            <p class="text-6xl text-gray-700">{{response.count_with_location}}</p>
                        </div>
                    </div>
                    <div class="max-w-sm rounded overflow-hidden relative shadow-lg">
                        <div class="px-6 py-4 text-center">
                            <h3 class="font-bold mb-3 text-gray-600">Total published projects</h3>
                            <p class="text-6xl text-gray-700">{{response.count}}</p>
                        </div>
                    </div>
                    <div class="max-w-sm rounded overflow-hidden relative shadow-lg">
                        <div class="px-6 py-4">
                            <h3 class="font-bold mb-3 text-center text-gray-600">Get involved!</h3>
                            <p class="text-gray-700">Become a contributor and help to improve the quality of the project
                                data.
                                Are you a project owner? Claim your project and keep your project updated. Learn more
                                about
                                the
                                <a href="https://positiveblockchain.io/about/" class="text-green-500" target="_blank"
                                   title="About us page">PositiveBlockchain Open Source community</a>.</p>
                        </div>
                    </div>
                </div>
                <div v-else class="flex justify-center">
                    <spinner></spinner>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Spinner from "../helpers/Spinner";
    import {LPopup, LIcon} from 'vue2-leaflet'
    import MapProjectCategoryFilterComponent from "./MapProjectCategoryFilterComponent";

    export default {
        name: "ProjectMapsComponent",
        components: {
            MapProjectCategoryFilterComponent,
            Spinner,
            LPopup,
            LIcon
        },
        data() {
            return {
                loaded: false,
                map: null,
                projects: [],
                categories: [],
                selectedCategories: [],
                response: null,
                tileProvider: {
                    maxZoom: 19,
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                },
            }
        },
        computed: {
            projectsFilteredByCategory: function () {
                if (this.selectedCategories.length > 0) {
                    return _.filter(this.projects, element => this.categoriesInProject(element))
                } else {
                    return this.projects;
                }
            },
            markersLoaded: function () {
                if (this.loaded) {
                    return this.projects.length === this.map._layers.length;
                }
            },
            getCategories: function () {
                if (this.loaded) {
                    _.each(this.projects, project => this.addCategory(project));
                    return this.categories;
                }
            }
        },
        created() {
            this.getProjectLocations();
            eventHub.$on('on-select-map-add-category', this.addSelectedCategory);
            eventHub.$on('on-select-map-remove-category', this.removeSelectedCategory);
            eventHub.$on('on-click-clear-filter', this.clearSelectedCategory);
        },
        mounted() {
            this.$nextTick(() => {
            });
        },
        methods: {
            clearSelectedCategory() {
                this.selectedCategories = [];
            },
            categoriesInProject(project) {
                if (project.hasOwnProperty('taxonomies')) {
                    return this.selectedCategories.find(element => element.name === project.main_category);
                }
                return false;
            },
            addSelectedCategory(category) {
                if (this.selectedCategoryExists(category) === undefined) {
                    this.selectedCategories.push(category);
                }
            },
            removeSelectedCategory(category) {
                const index = this.selectedCategories.findIndex(element => element.term_id === category.term_id);
                Vue.delete(this.selectedCategories, index);
            },
            selectedCategoryExists(category) {
                return this.selectedCategories.find(element => element.term_id === category.term_id);
            },
            addCategory(project) {
                const category = this.findCategoryNameInTaxonomy(project.main_category, project.taxonomies);
                const match = this.categories.find(element => project.main_category === element.name);
                if (match) {
                    return;
                } else {
                    this.categories.push(category);
                }
            },
            findCategoryNameInTaxonomy(category, taxonomies) {
                if (Array.isArray(taxonomies)) {
                    const match = taxonomies.find(element => element.term.name === category);
                    if (match.hasOwnProperty('term')) {
                        return match.term;
                    }
                    return false;
                }
                return false;
            },
            isEmpty(string) {
                return !_.isEmpty(string);
            },
            getAbstract(content) {
                if (_.includes(content, '<')) {
                    const htmlContent = content;
                    const wrapper = document.createElement("div");
                    wrapper.innerHTML = htmlContent;
                    let text = wrapper.textContent || wrapper.innerText || "";
                    return _.truncate(text, {length: 150});

                }
                return _.truncate(content, {length: 150});
            },
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
                    const response = await axios.get('api/v1/project-locations');
                    this.response = response.data;
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
        height: 200px;
        min-height: 600px;
    }

    .map-project-logo {
        width: 50px;
    }
</style>
