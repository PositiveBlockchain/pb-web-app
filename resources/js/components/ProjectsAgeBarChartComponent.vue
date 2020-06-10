<template>
    <div id="chart-project-foundation-years">
        <h2 class="text-center uppercase mb-5 text-2xl"><slot></slot></h2>
        <bar-chart v-if="loaded" :options="options" :chartdata="getChartData"></bar-chart>
    </div>
</template>

<script>
    import BarChart from "./charts/BarChart";

    export default {
        name: "ProjectsAgeBarChartComponent",
        components: {BarChart},
        data() {
            return {
                loaded: false,
                responseData: null,
                projectYears: null,
                yearCounts: null,
                chartdata: null,
                options: {},
            }
        },
        created() {
            this.getProjectAgesReport();
        },
        computed: {
            getChartData: function () {
                this.chartdata = {
                    labels: _.keys(this.responseData),
                    datasets: [{
                        data: _.values(this.responseData),
                    }],
                };

                return this.chartdata;
            }
        },
        methods: {
            getProjectAgesReport: async function () {
                this.loaded = false;
                try {
                    const response = await axios.get('api/v1/reports/project-ages');
                    if(response.data.status === "ok")
                    {
                        this.responseData = response.data.data;
                        this.loaded = true;
                    }
                } catch (e) {
                    console.error(e);
                }
            }
        }
    }
</script>

<style scoped>

</style>
