<template>
    <div>
        <div v-if="sdgFilter" v-bind="sdgFilter" class="text-center mb-5">
            Filter selected:
            <span class="text-sm font-bold bg-green-500 text-white py-2 px-3 rounded">
            {{sdgFilter.goal_number}} {{sdgFilter.goal_name}}
                <button type="button"
                        class="text-sm bg-red-500 hover:bg-red-200 text-white font-bold py-1 px-2 mb-1 rounded"
                        v-on:click.prevent="clear()">X
                </button>
            </span>

        </div>
        <div v-if="loaded" class="project-list grid grid-cols-6 lg:grid-cols-7 sm:grid-cols-4 gap-4">
            <div v-for="project in projectsFiltered"
                 class="project-list-item max-w-sm rounded bg-white shadow">
                <div class="px-3 py-2">
                    <div class="text-sm mb-2 mt-2 short-description">{{project.title}}</div>
                </div>
                <a :href="project.permalink"
                   class="hover:border-green-500"
                   target="_blank"> <img class="object-center w-full h-auto" :src="project.fields.business_logo"
                                         @error="getDefaultImage($event)"
                                         :alt="'project logo ' + project.title"/></a>
            </div>
        </div>
        <div v-else class="flex justify-center">
            <spinner></spinner>
        </div>
    </div>
</template>

<script>
    import Spinner from "../helpers/Spinner";

    export default {
        name: "ProjectsAllListComponent",
        components: {Spinner},
        data() {
            return {
                projects: [],
                filteredProjects: [],
                loaded: false,
                response: null,
                sdgFilter: null,
            }
        },
        created() {
            this.getProjects();
            eventHub.$on('pb-sdg-filter', this.filterProjectsBySdg);
        },
        computed: {
            projectsFiltered: function () {
                if (this.sdgFilter === null) {
                    return this.projects;
                } else if (this.filteredProjects.length > 0) {
                    return this.filteredProjects;
                }
            },
        },
        methods: {
            getDefaultImage(event) {
                event.target.src = '/storage/icons/default-error-logo.png';
            },
            clear() {
                this.sdgFilter = null;
            },
            filterProjectsBySdg(sdgGoal) {
                this.sdgFilter = sdgGoal;
                this.filteredProjects = _.filter(this.projects, project => this.hasGoalNumber(project))
            },
            hasGoalNumber(project) {
                if (project.fields.hasOwnProperty('sdg')) {
                    const goalNumber = this.sdgFilter.goal_number;
                    return _.includes(project.fields.sdg, goalNumber.toString());
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
            showKeyWord(keyword) {
                return _.trim(keyword).replace("&amp;", "&");
            },
            getProjects: async function () {
                this.loaded = false;
                try {
                    const response = await axios.get('/api/v1/projects?limit=1000');
                    if (response.data.status === 'ok') {
                        this.response = response.data;
                        this.projects = response.data.data;
                        eventHub.$emit('on-all-projects-loaded', this.projects);
                        this.loaded = true;
                    }

                } catch (e) {
                    console.error(e);
                }
            }
        }
    }
</script>

<style scoped>

</style>
