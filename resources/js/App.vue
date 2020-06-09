<template>
    <div id="dashboard">
        <div>
            <projects-by-category-pie-chart-component>
                Projects by Categories
            </projects-by-category-pie-chart-component>
        </div>
        <div class="mt-10">
            <project-locations-pie-chart-component>
                Projects by Locations
            </project-locations-pie-chart-component>
        </div>
    </div>
</template>

<script>
    import ProjectsByCategoryPieChartComponent from "./components/ProjectsByCategoryPieChartComponent";
    import ProjectLocationsPieChartComponent from "./components/ProjectLocationsPieChartComponent";

    export default {
        name: "App",
        components: {ProjectLocationsPieChartComponent, ProjectsByCategoryPieChartComponent},
        data() {
            return {}
        },
        created() {

        },
        mounted() {

        },
        methods: {}
    }
</script>

<style scoped>

</style>
