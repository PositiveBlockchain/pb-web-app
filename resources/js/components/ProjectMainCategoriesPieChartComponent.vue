<template>
    <div id="chart-project-main-categories" class="p-3 shadow-lg bg-white m-1">
        <h2 class="text-center uppercase mb-5 text-2xl">
            <slot></slot>
        </h2>
        <pie-chart v-if="loaded" :chartdata="chartdata" :options="options"></pie-chart>
    </div>
</template>

<script>
    import PieChart from "./charts/PieChart";

    export default {
        name: "ProjectMainCategoriesPieChartComponent",
        components: {PieChart},
        data() {
            return {
                loaded: false,
                chartdata: null,
                categories: null,
                options: {
                    responsive: true,
                    cutoutPercentage: 50,
                    borderWidth: 0,
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
                    this.categories = response.data.data;
                    const values = _.values(this.categories);
                    this.chartdata = {
                        labels: _.keys(this.categories),
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
