<template>
    <div id="chart_project_categories">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="category-count-filter">
            Category filter
        </label>
        <div class="inline-block relative w-64">
            <select id="category-count-filter" v-model="currentCountFilter"
                    class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                <option v-bind:value="1" selected> Category with > 1 Project </option>
                <option v-bind:value="5"> Category with > 5 Projects</option>
                <option v-bind:value="10"> Category with > 10 Projects</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                </svg>
            </div>
        </div>
        <pie-chart v-if="loaded" :chartdata="filteredTaxonomies" :options="options"></pie-chart>
    </div>
</template>
<script>
    import {Pie} from "vue-chartjs";
    import PieChart from "./charts/PieChart";

    export default {
        name: "ProjectsByCategoryBarChartComponent",
        components: {PieChart},
        extends: Pie,
        props: {
            taxonomyCountFilterProperty: {
                type: Number,
                default: null
            },
        },
        data() {
            return {
                loaded: false,
                chartdata: null,
                taxonomies: null,
                currentCountFilter: null,
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
        computed: {
            filteredTaxonomies: function () {
                const filtered = _.filter(this.taxonomies, taxonomy => {
                    return taxonomy.count > this.currentCountFilter;
                });

                const values = _.orderBy(_.map(filtered, 'count'));
                this.chartdata = {
                    labels: _.map(filtered, 'name'),
                    datasets: [{
                        label: 'Project Categories',
                        data: values,
                        backgroundColor: this.generatePieColors(values),
                    }],
                };

                return this.chartdata;
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
            assignDataToChart() {

            },
            getProjectCategoryReport: async function () {
                this.loaded = false;
                try {
                    const response = await axios.get('api/v1/reports/projects');
                    this.taxonomies = response.data.data;
                    this.assignDataToChart();
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
