<template>
    <projects-by-category-bar-chart-component v-if="loaded" :chartdata="chartdata" :options="options"/>
</template>

<script>
    import ProjectsByCategoryBarChartComponent from "./components/ProjectsByCategoryBarChartComponent";

    export default {
        name: "App",
        components: {ProjectsByCategoryBarChartComponent},
        data() {
            return {
                loaded: false,
                chartdata: null,
                taxonomies: null,
                options: {
                    responsive: true,
                    cutoutPercentage: 50,
                    borderWidth: 0,
                    tooltips: {
                        enabled: true,
                    }
                }
            }
        },
        created() {
            this.getProjectCategoryReport();
        },
        mounted() {

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
            getProjectCategoryReport: async function () {
                this.loaded = false;
                try {
                    const response = await axios.get('api/v1/reports/projects');
                    this.taxonomies = response.data.data;
                    const values = _.map(this.taxonomies, 'count');
                    this.chartdata = {
                        labels: _.map(this.taxonomies, 'name'),
                        datasets: [{
                            label: 'Project Categories',
                            data: values,
                            backgroundColor: this.generatePieColors(values),
                        }],
                    };
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
