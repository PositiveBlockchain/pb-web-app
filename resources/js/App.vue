<template>
    <div id="dashboard" class="container">
        <div class="p-3 shadow-lg bg-white m-1 mb-2">
            <project-categories-pie-charts-component/>
        </div>
        <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-2">
            <projects-organization-types-pie-chart-component/>
            <projects-stages-horizontal-bar-chart-component/>
            <div class="">
                <projects-countries-pie-chart-component/>
            </div>
            <div class="">
                <projects-age-bar-chart-component/>
            </div>
        </div>

    </div>
</template>

<script>
    import ProjectsByCategoryPieChartComponent from "./components/ProjectsByCategoryPieChartComponent";
    import ProjectsCountriesPieChartComponent from "./components/ProjectsCountriesPieChartComponent";
    import ProjectsAgeBarChartComponent from "./components/ProjectsAgeBarChartComponent";
    import ProjectsOrganizationTypesPieChartComponent from "./components/ProjectsOrganizationTypesPieChartComponent";
    import ProjectsStagesHorizontalBarChartComponent from "./components/ProjectsStagesHorizontalBarChartComponent";
    import ProjectCategoriesPieChartsComponent from "./components/ProjectCategoriesPieChartsComponent";

    export default {
        name: "App",
        components: {
            ProjectCategoriesPieChartsComponent,
            ProjectsStagesHorizontalBarChartComponent,
            ProjectsOrganizationTypesPieChartComponent,
            ProjectsAgeBarChartComponent,
            ProjectsCountriesPieChartComponent,
            ProjectsByCategoryPieChartComponent
        },
    }
</script>

<style scoped>

</style>
