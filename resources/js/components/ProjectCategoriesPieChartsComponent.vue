<template>
    <div class="grid sm:grid-cols-1 lg:grid-cols-2 md:grid-cols-2 gap-2">
        <project-main-categories-pie-chart-component/>
        <project-sub-categories-pie-chart-component/>
    </div>
</template>

<script>
    import ProjectMainCategoriesPieChartComponent from "./ProjectMainCategoriesPieChartComponent";
    import ProjectSubCategoriesPieChartComponent from "./ProjectSubCategoriesPieChartComponent";

    export default {
        name: "ProjectCategoriesPieChartsComponent",
        components: {ProjectSubCategoriesPieChartComponent, ProjectMainCategoriesPieChartComponent},
    }
</script>

<style scoped>

</style>
