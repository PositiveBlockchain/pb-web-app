<template>
    <div id="chart-project-main-categories" class="p-3 shadow-lg bg-white m-1">
        <div v-if="mainCategory">
            <div v-if="loaded" class="chart">
                <pie-chart :chartdata="filterSubCategoriesByParentCategory" :options="getOptions"></pie-chart>
            </div>
            <div v-else class="flex justify-center">
                <spinner></spinner>
            </div>
        </div>
        <div v-else class="flex justify-center">
            <h3 class="text-2xl">Select a main category to <br> display the sub categories.</h3>
        </div>
    </div>
</template>

<script>
    import PieChart from "./charts/PieChart";
    import Spinner from "./helpers/Spinner";

    export default {
        name: "ProjectSubCategoriesPieChartComponent",
        components: {Spinner, PieChart},
        data() {
            return {
                loaded: false,
                chartdata: null,
                subCategories: [],
                mainCategory: null,
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
            },
            filterSubCategoriesByParentCategory() {
                let filteredSubCategories = null;
                if (this.mainCategory.hasOwnProperty('term_taxonomy_id') && this.mainCategory.term_taxonomy_id) {
                    filteredSubCategories = _.filter(this.subCategories, ['parent', this.mainCategory.term_taxonomy_id]);
                }
                const values = _.map(filteredSubCategories, 'count');
                this.options.title.text = this.options.title.text + ' ' + this.mainCategory.name;
                this.chartdata = {
                    labels: _.map(filteredSubCategories, 'name'),
                    datasets: [{
                        label: 'Project Sub Categories for ' + this.mainCategory.name,
                        data: values,
                        backgroundColor: this.generatePieColors(values),
                    }],
                }
                return this.chartdata;
            },
        },
        created() {
            eventHub.$on('on-change-main-category', this.displaySubCategories)
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
            displaySubCategories(mainCategory) {
                this.mainCategory = mainCategory;
                if (this.subCategories.length === 0 && typeof mainCategory === 'object') {
                    this.getProjectSubCategoryReport();
                }
            },
            getProjectSubCategoryReport: async function () {
                this.loaded = false;
                try {
                    const response = await axios.get('api/v1/reports/project-sub-categories');
                    this.response = response.data;
                    this.subCategories = response.data.data;
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
