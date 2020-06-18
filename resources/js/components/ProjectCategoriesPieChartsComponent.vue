<template>
    <div class="grid grid-cols-2 gap-2">
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
        data() {
            return {}
        },
        computed: {},
        created() {
        },
        methods: {}
    }
</script>

<style scoped>

</style>
