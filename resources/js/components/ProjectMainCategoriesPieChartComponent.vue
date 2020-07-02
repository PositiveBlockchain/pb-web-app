<template>
    <div id="chart-project-main-categories" class="px-4">
        <div v-if="loaded" class="chart">
            <div id="filter_category_by_count" class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                       for="category-count-filter">
                    Show sub categories from
                </label>
                <div class="relative">
                    <select id="category-count-filter" v-model="selectedCategory"
                            v-on:change="onChangeLoadSubCategories"
                            class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                        <option value="not_selected" selected>Select your category</option>
                        <option v-for="category in mainCategories"
                                v-bind:value="category">{{category.name}}
                        </option>
                    </select>
                    <div
                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                        </svg>
                    </div>
                </div>
            </div>
            <pie-chart :chartdata="chartdata" :options="getOptions"></pie-chart>
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
                mainCategories: null,
                response: null,
                selectedCategory: 'not_selected',
                colors: [],
                options: {
                    responsive: true,
                    cutoutPercentage: 70,
                    borderWidth: 0,
                    legend: {
                        position: 'left',
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
            }
        },
        created() {
            this.getProjectMainCategoryReport();
        },
        methods: {
            onChangeLoadSubCategories() {
                const index = this.mainCategories.findIndex(element => element.term_taxonomy_id === this.selectedCategory.term_taxonomy_id);
                const categoryColor = this.colors[index];
                const category = {color: categoryColor, category: this.selectedCategory};
                eventHub.$emit('on-change-main-category', category);
            },
            generatePieColors(values) {
                for (let i = 0; i < values.length; i++) {
                    let red = Math.floor(Math.random() * 200);
                    let green = Math.floor(Math.random() * 200);
                    let blue = Math.floor(Math.random() * 200);
                    let color = 'rgb(' + red + ', ' + green + ', ' + blue + ')';
                    this.colors.push(color);
                }
                return this.colors;
            },
            getProjectMainCategoryReport: async function () {
                this.loaded = false;
                try {
                    const response = await axios.get('api/v1/reports/project-main-categories');
                    this.response = response.data;
                    this.mainCategories = response.data.data;
                    const values = _.map(this.mainCategories, 'count');
                    this.chartdata = {
                        labels: _.map(this.mainCategories, 'name'),
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
