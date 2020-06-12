<template>
    <div id="chart-project-stages" class="p-3 shadow-lg bg-white m-1">
        <horizontal-bar-chart v-if="loaded" :options="getOptions" :chartdata="getChartData"></horizontal-bar-chart>
    </div>

</template>

<script>
    import BarChart from "./charts/BarChart";
    import HorizontalBarChart from "./charts/HorizontalBarChart";

    export default {
        name: "ProjectsStagesHorizontalBarChartComponent",
        components: {HorizontalBarChart, BarChart},
        data() {
            return {
                loaded: false,
                response: null,
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
            this.getProjectStagesReport();
        },
        computed: {
            getOptions: function () {
                if (this.loaded) {
                    this.options.title.text = _.upperCase(this.response.chart_title);
                    return this.options;
                }
            },
            getChartData: function () {
                const values = _.values(this.response.data);
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
            getProjectStagesReport: async function () {
                this.loaded = false;
                try {
                    const response = await axios.get('api/v1/reports/project-stages');
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
