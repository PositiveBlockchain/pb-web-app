<template>
    <div id="dashboard">
        <projects-by-category-bar-chart-component :taxonomy-count-filter-property="10" />
    </div>
</template>

<script>
    import ProjectsByCategoryBarChartComponent from "./components/ProjectsByCategoryBarChartComponent";

    export default {
        name: "App",
        components: {ProjectsByCategoryBarChartComponent},
        data() {
            return {

            }
        },
        created() {

        },
        mounted() {

        },
        methods: {

        }
    }
</script>

<style scoped>

</style>
