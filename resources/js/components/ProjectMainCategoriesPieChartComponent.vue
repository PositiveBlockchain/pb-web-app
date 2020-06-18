<template>
    <div id="chart-project-main-categories" class="p-3 shadow-lg bg-white m-1">
        <div v-if="loaded" class="chart">
            <pie-chart v-if="loaded" :chartdata="chartdata" :options="getOptions"></pie-chart>
        </div>
        <div v-else class="flex justify-center">
            <spinner></spinner>
        </div>
    </div>
</template>

<script>
    import PieChart from "./charts/PieChart";
    import Spinner from "./helpers/Spinner";

    export default {
        name: "ProjectMainCategoriesPieChartComponent",
        components: {Spinner, PieChart},
        data() {
            return {
                loaded: false,
                chartdata: null,
                categories: null,
                response: null,
                options: {
                    responsive: true,
                    cutoutPercentage: 50,
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
        computed: {
            getOptions: function () {
                if (this.loaded) {
                    this.options.title.text = _.upperCase(this.response.chart_title);
                    return this.options;
                }
            }
        },
        created() {
            this.getProjectMainCategoryReport();
        },
        methods: {
            generatePieColors(values) {
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
            getProjectMainCategoryReport: async function () {
                this.loaded = false;
                try {
                    const response = await axios.get('api/v1/reports/project-main-categories');
                    this.response = response.data;
                    this.categories = response.data.data;
                    const values = _.map(this.categories, 'count');
                    this.chartdata = {
                        labels: _.map(this.categories, 'name'),
                        datasets: [{
                            label: 'Project Main Categories',
                            data: values,
                            backgroundColor: this.generatePieColors(values),
                        }],
                    }
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
