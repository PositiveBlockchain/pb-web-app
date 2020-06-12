<template>
    <div id="dashboard">
        <div>
            <projects-by-category-pie-chart-component>
                Projects by Categories
            </projects-by-category-pie-chart-component>
        </div>
        <div class="grid grid-cols-2 gap-2">
            <projects-organization-types-bar-chart-component>
                Projects Organization Types
            </projects-organization-types-bar-chart-component>
            <projects-stages-horizontal-bar-chart-component>
                Project Stages
            </projects-stages-horizontal-bar-chart-component>
            <div class="">
                <projects-countries-pie-chart-component>
                    Projects by Countries
                </projects-countries-pie-chart-component>
            </div>
            <div class="">
                <projects-age-bar-chart-component>
                    Project Foundation Years
                </projects-age-bar-chart-component>
            </div>
        </div>

    </div>
</template>

<script>
    import ProjectsByCategoryPieChartComponent from "./components/ProjectsByCategoryPieChartComponent";
    import ProjectsCountriesPieChartComponent from "./components/ProjectsCountriesPieChartComponent";
    import ProjectsAgeBarChartComponent from "./components/ProjectsAgeBarChartComponent";
    import ProjectsOrganizationTypesBarChartComponent from "./components/ProjectsOrganizationTypesBarChartComponent";
    import ProjectMainCategoriesPieChartComponent from "./components/ProjectMainCategoriesPieChartComponent";
    import ProjectsStagesHorizontalBarChartComponent from "./components/ProjectsStagesHorizontalBarChartComponent";

    export default {
        name: "App",
        components: {
            ProjectsStagesHorizontalBarChartComponent,
            ProjectMainCategoriesPieChartComponent,
            ProjectsOrganizationTypesBarChartComponent,
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
