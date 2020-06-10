<template>
    <div id="dashboard">
        <div>
            <projects-by-category-pie-chart-component>
                Projects by Categories
            </projects-by-category-pie-chart-component>
        </div>
        <div class="mt-10">
            <projects-countries-pie-chart-component>
                Projects by Countries
            </projects-countries-pie-chart-component>
        </div>
        <div class="mt-10">
            <projects-age-bar-chart-component>
               Projects Foundation Year
            </projects-age-bar-chart-component>
        </div>
    </div>
</template>

<script>
    import ProjectsByCategoryPieChartComponent from "./components/ProjectsByCategoryPieChartComponent";
    import ProjectsCountriesPieChartComponent from "./components/ProjectsCountriesPieChartComponent";
    import ProjectsAgeBarChartComponent from "./components/ProjectsAgeBarChartComponent";

    export default {
        name: "App",
        components: {
            ProjectsAgeBarChartComponent,
            ProjectsCountriesPieChartComponent,
            ProjectsByCategoryPieChartComponent
        },
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
