<template>
    <div class="sdg-goals-list grid grid-cols-4 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-6 lg:grid-cols-6 gap-1">
        <div v-if="loaded" v-for="sdg in sdgs" class="shadow relative sdg-goal-icon">
            <button
                class="btn-sdg-filter hidden text-sm bg-green-500 hover:bg-green-500 text-white font-bold py-2 px-3 mb-1 rounded bottom-0 right-0 absolute bg-opacity-50"
                v-on:click.prevent="filterSdg(sdg)">
                filter
            </button>
            <img class="sdg-goal-icon-image cursor-pointer" :src="sdg.goal_icon_path"
                 v-bind:alt="sdg.goal_name + 'icon'"
                 v-on:click.prevent="showModal(sdg)"/>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SdgGoalsListComponent",
        data() {
            return {
                loaded: false,
                response: null,
                sdgs: [],
            }
        },
        created() {
            this.getSdgGoals();
        },
        methods: {
            filterSdg(sdgGoal) {
                eventHub.$emit('pb-sdg-filter', sdgGoal);
            },
            showModal(sdgGoal) {
                const modalData = {
                    title: sdgGoal.goal_number + ' ' + sdgGoal.goal_name,
                    body: '<img src="' + sdgGoal.goal_icon_path + '" class="w-1/2 float-left"/>' + sdgGoal.description,
                    data: sdgGoal
                };
                eventHub.$emit('pb-modal-show', modalData);
            },
            getSdgGoals: async function () {
                this.loaded = false;
                try {
                    const response = await axios.get(
                        'api/v1/sdgs'
                    );
                    this.response = response.data;
                    this.sdgs = response.data;
                    eventHub.$emit('pb-sdgs-loaded', this.sdgs);
                    this.loaded = true;
                } catch (e) {
                    console.log(e);
                }
            },
        }
    }
</script>

<style scoped>
    .sdg-goal-icon:hover .btn-sdg-filter {
        display: block;
    }
</style>
