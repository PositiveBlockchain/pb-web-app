<template>
    <div class="sdg-goals grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
        <div class="md:col-span-1">
            <sdg-goals-list-component></sdg-goals-list-component>
        </div>
        <div class="md:col-span-1 bg-white shadow p-5">
            <h2 class="text-center"></h2>
            <sdg-project-distribution-pie-chart></sdg-project-distribution-pie-chart>
        </div>
    </div>
</template>

<script>
    import SdgGoalsListComponent from "./SdgGoalsListComponent";
    import SdgProjectDistributionPieChart from "./SdgProjectDistributionPieChart";

    export default {
        name: "SdgGoalsComponent",
        components: {SdgProjectDistributionPieChart, SdgGoalsListComponent}
    }
</script>

<style scoped>

</style>
