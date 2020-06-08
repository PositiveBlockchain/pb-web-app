<script>
    import {Pie} from "vue-chartjs";

    export default {
        name: "ProjectsByCategoryBarChartComponent",
        extends: Pie,
        props: {
            chartdata: {
                type: Object,
                default: null
            },
            options: {
                type: Object,
                default: null
            }
        },
        data: () => ({}),
        mounted() {
            this.renderChart(this.chartdata, this.options)
        },
        methods: {

        }
    }
</script>

<style scoped>

</style>
