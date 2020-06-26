<template>
    <div class="sdg-goals-list grid grid-cols-4 sm:grid-cols-4 md:grid-cols-8 lg:grid-cols-10 lg:grid-cols-12 gap-1">
        <div v-if="loaded" v-for="sdg in sdgs" class="shadow">
            <img :src="sdg.goal_icon_path" v-bind:alt="sdg.goal_name + 'icon'" v-on:click.prevent="showModal(sdg)"/>
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
            showModal(sdgGoal) {
                const modalData = {
                    title: sdgGoal.goal_number + ' ' + sdgGoal.goal_name,
                    body: '<img src="'+sdgGoal.goal_icon_path+'" class="w-1/2 float-left"/>'+sdgGoal.description,
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
                    this.loaded = true;
                } catch (e) {
                    console.log(e);
                }
            },
        }
    }
</script>

<style scoped>

</style>
