<template>

</template>

<script>
	export default {
		name: "PieChart",
        data() {
		    return {

            }
        },
        methods:{
            getProjectCategoryReport: async function () {
                this.loaded = false;
                try {
                    const response = await axios.get('api/v1/reports/projects');
                    this.taxonomies = response.data.data;
                    const counts = _.map(this.taxonomies, 'count');
                    this.chartdata = {
                        labels: _.map(this.taxonomies, 'name'),
                        datasets: [{
                            label: '# of Votes',
                            data: counts
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
