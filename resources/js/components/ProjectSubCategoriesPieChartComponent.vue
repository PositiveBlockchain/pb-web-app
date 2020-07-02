<template>
    <div id="chart-project-sub-categories" class="border-l border-gray-600 px-4">
        <div v-if="mainCategory">
            <div v-if="loaded" class="chart">
                <pie-chart :chartdata="filterSubCategoriesByParentCategory" :options="getOptions"></pie-chart>
            </div>
            <div v-else class="flex justify-center">
                <spinner></spinner>
            </div>
        </div>
        <div v-else class="flex justify-center">
            <h3 class="text-lg uppercase mt-4">Select a main category to <br> display the sub categories</h3>
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
                mainCategoryColor: null,
                response: null,
                options: {
                    responsive: true,
                    borderWidth: 0,
                    legend: {
                        position: 'right',
                    },
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
                const newTitle = 'Project sub categories for ' + this.mainCategory.name;
                this.options.title.text = _.upperCase(newTitle);
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
                const rgb = this.mainCategoryColor.replace(/[^\d,]/g, '').split(',');
                const red = rgb[0];
                const green = rgb[1];
                const blue = rgb[2];
                const alphaStep = 1.0 / values.length;

                const colors = [];
                for (let i = 1; i < values.length + 1; i++) {
                    let alpha = alphaStep * i;
                    let color = 'rgba(' + red + ', ' + green + ', ' + blue + ', ' + alpha + ')';
                    console.log(color);
                    colors.push(color);
                }
                return colors;
            },
            displaySubCategories(mainCategory) {
                this.mainCategory = mainCategory.category;
                this.mainCategoryColor = mainCategory.color;
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
