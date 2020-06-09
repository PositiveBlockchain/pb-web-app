<template>
    <div id="dashboard">
        <projects-by-category-pie-chart-component :taxonomy-count-filter-property="10" />
    </div>
</template>

<script>
    import ProjectsByCategoryPieChartComponent from "./components/ProjectsByCategoryPieChartComponent";

    export default {
        name: "App",
        components: {ProjectsByCategoryPieChartComponent},
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
