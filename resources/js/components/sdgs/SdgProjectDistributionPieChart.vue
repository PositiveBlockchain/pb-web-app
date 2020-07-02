<template>
    <div class="sdg-projects-pie-chart">
        <pie-chart v-if="loaded" :chartdata="generateChartData" :options="getOptions">

        </pie-chart>
        <div v-else class="flex justify-center">
            <spinner></spinner>
        </div>
    </div>
</template>

<script>
    import PieChart from "../charts/PieChart";
    import Spinner from "../helpers/Spinner";

    export default {
        name: "SdgProjectDistributionPieChart",
        components: {Spinner, PieChart},
        data() {
            return {
                loaded: false,
                chartdata: null,
                response: null,
                sdgs: [],
                options: {
                    cutoutPercentage: 70,
                    legend: {
                      position: 'bottom',
                    },
                    responsive: true,
                    borderWidth: 0,
                    title: {
                        display: true,
                        text: '',
                    },
                    tooltips: {
                        enabled: true,
                        bodyFontSize: 30,
                        callbacks: {
                            label: function (tooltipItem, data) {
                                let percentage = data['datasets'][0]['data'][tooltipItem['index']] * 100 / _.sum(data['datasets'][0]['data']);
                                return data['labels'][tooltipItem['index']] + ': ' + _.round(percentage, 2) + '%';
                            }
                        }
                    }
                }
            }
        },
        created() {
            eventHub.$on('pb-sdgs-loaded', this.initSdgs);
            this.getProjectSdgsReport();
        },
        computed: {
            getOptions: function () {
                if (this.loaded) {
                    this.options.title.text = _.upperCase(this.response.chart_title);
                    return this.options;
                }
            },
            generateChartData: function () {
                if (this.sdgs.length > 0 && this.loaded) {
                    const values = _.values(this.response.data);
                    this.chartdata = {
                        labels: _.map(this.sdgs, goal => this.getSdgGoalNameWithNumber(goal)),
                        datasets: [{
                            label: 'Project Sdgs',
                            data: values,
                            backgroundColor: this.getSDGColors(),
                        }],
                    }
                    return this.chartdata;
                }
            }
        },
        methods: {
            getSdgGoalNameWithNumber(goal) {
                return goal.goal_number + ': ' + goal.goal_name;
            },
            initSdgs(sdgs) {
                this.sdgs = sdgs;
            },
            getSDGColors() {
                return [
                    'rgb(229, 36, 45)',
                    'rgb(221, 168, 58)',
                    'rgb(76, 159, 56)',
                    'rgb(197, 25, 45)',
                    'rgb(255, 58, 33)',
                    'rgb(38, 189, 226)',
                    'rgb(252, 159, 11)',
                    'rgb(162, 25, 66)',
                    'rgb(253, 105, 37)',
                    'rgb(221, 19, 103)',
                    'rgb(253, 157, 36)',
                    'rgb(191, 139, 46)',
                    'rgb(63, 126, 68)',
                    'rgb(10, 151, 217)',
                    'rgb(86, 192, 43)',
                    'rgb(0, 104, 157)',
                    'rgb(25, 72, 106)',
                ];
            },
            getProjectSdgsReport: async function () {
                this.loaded = false;
                try {
                    const response = await axios.get('api/v1/reports/project-sdgs');
                    this.response = response.data;
                    this.loaded = true;
                } catch (e) {
                    console.error(e);
                }
            }
        }
    }
</script>

<style scoped>

</style>
