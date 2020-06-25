<template>
    <div class="projects-list grid grid-cols-3 gap-4">
        <div v-if="projects" v-for="project in projects" class="max-w-sm rounded overflow-hidden relative shadow-lg">
            <div class="px-6 py-4 mb-24">
                <div class="font-bold text-xl mb-2 mt-2">{{project.title}}</div>
                <p v-if="isEmpty(project.fields.short_description)" class="text-gray-700 text-base">
                    {{getAbstract(project.fields.short_description)}}
                </p>
                <p v-else class="text-gray-700 text-base">
                    {{getAbstract(project.content)}}
                </p>
            </div>
            <div class="px-6 py-4 absolute inset-x-0 bottom-0">
                <p class="text-sm text-gray-600 flex items-center">Created: {{project.post_date}}</p>
                <p class="text-sm text-gray-600 flex items-center">Updated: {{project.post_modified}}</p>
                <a :href="project.permalink"
                   class="float-right text-green-500 border rounded p-2 hover:text-green-800 border-green-500"
                   target="_blank">View</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ProjectsListComponent",
        data() {
            return {
                projects: [],
                response: null,
            }
        },
        created() {
            this.getMostActiveProjects();
        },
        methods: {
            isEmpty(string) {
                return !_.isEmpty(string);
            },
            getAbstract(content) {
                if (_.includes(content, '<')) {
                    const htmlContent = content;
                    console.log(content);
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
            getMostActiveProjects: async function () {
                try {
                    const response = await axios.get('/api/v1/projects-active');
                    if (response.data.status === 'ok') {
                        this.response = response.data;
                        this.projects = response.data.data;
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
