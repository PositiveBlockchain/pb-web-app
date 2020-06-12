<template>
    <div id="chart-project-organization-types" class="p-3 shadow-lg bg-white m-1">
        <div v-if="loaded" class="chart">
            <bar-chart :options="getOptions" :chartdata="getChartData"></bar-chart>
            <small class="mt-3 block">Projects with unknown types aren't included</small>
        </div>
        <div v-else class="flex justify-center">
            <spinner></spinner>
        </div>
    </div>
</template>

<script>
    import BarChart from "./charts/BarChart";
    import Spinner from "./helpers/Spinner";

    export default {
        name: "ProjectsOrganizationTypesBarChartComponent",
        components: {Spinner, BarChart},
        data() {
            return {
                loaded: false,
                response: null,
                projectYears: null,
                yearCounts: null,
                chartdata: null,
                options: {
                    legend: {
                        display: false,
                    },
                    title: {
                        display: true,
                        text: '',
                    }
                },
            }
        },
        created() {
            this.getProjectAgesReport();
        },
        computed: {
            getOptions: function () {
                if (this.loaded) {
                    this.options.title.text = _.upperCase(this.response.chart_title);
                    return this.options;
                }
            },
            getChartData: function () {
                const values = _.values(this.response.data)
                this.chartdata = {
                    labels: _.keys(this.response.data),
                    datasets: [{
                        label: "",
                        data: values,
                        backgroundColor: this.generateColors(values),
                    }
                    ],
                };
                return this.chartdata;
            }
        },
        methods: {
            generateColors(values) {
                const colors = [];
                for (let i = 0; i < values.length; i++) {
                    let red = Math.floor(Math.random() * 200);
                    let green = Math.floor(Math.random() * 200);
                    let blue = Math.floor(Math.random() * 200);
                    let color = 'rgb(' + red + ', ' + green + ', ' + blue + ')';
                    colors.push(color);
                }
                return colors;
            },
            getProjectAgesReport: async function () {
                this.loaded = false;
                try {
                    const response = await axios.get('api/v1/reports/project-organization-types');
                    if (response.data.status === "ok") {
                        this.response = response.data;
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
