<template>
    <div id="chart-project-locations" class="p-3 shadow-lg bg-white m-1">
        <pie-chart :chartdata="filteredTaxonomies" :options="getOptions"></pie-chart>
    </div>
</template>

<script>
    import PieChart from "./charts/PieChart";

    export default {
        name: "ProjectsCountriesPieChartComponent",
        components: {PieChart},
        data() {
            return {
                loaded: false,
                response: null,
                chartdata: null,
                taxonomies: null,
                currentTopFilter: 0,
                options: {
                    responsive: true,
                    cutoutPercentage: 50,
                    borderWidth: 0,
                    currentCountFilter: 1,
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
            },
            filteredTaxonomies: function () {
                const values = _.map(this.taxonomies, 'count');
                this.chartdata = {
                    labels: _.map(this.taxonomies, 'name'),
                    datasets: [{
                        label: 'Project Locations',
                        data: values,
                        backgroundColor: this.generatePieColors(values),
                    }],
                };

                return this.chartdata;
            }
        },
        created() {
            this.getProjectLocations();
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
            getProjectLocations: async function () {
                this.loaded = false;
                try {
                    const response = await axios.get('api/v1/reports/project-locations');
                    this.response = response.data;
                    this.taxonomies = this.response.data;
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
