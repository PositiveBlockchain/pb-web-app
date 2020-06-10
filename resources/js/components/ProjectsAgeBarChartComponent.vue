<template>
    <div id="chart-project-foundation-years" class="p-3 shadow-lg bg-white m-1">
        <h2 class="text-center uppercase mb-5 text-2xl">
            <slot></slot>
        </h2>
        <bar-chart v-if="loaded" :options="options" :chartdata="getChartData"></bar-chart>
    </div>
</template>

<script>
    import BarChart from "./charts/BarChart";
    import Helper from "vue-chartjs"

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
                options: {
                    legend: {
                        display: false,
                    }
                },
            }
        },
        created() {
            this.getProjectAgesReport();
        },
        computed: {
            getChartData: function () {
                const values = _.values(this.responseData)
                this.chartdata = {
                    labels: _.keys(this.responseData),
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
                    const response = await axios.get('api/v1/reports/project-ages');
                    if (response.data.status === "ok") {
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
