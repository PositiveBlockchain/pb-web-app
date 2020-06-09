<script>
    import {Pie} from "vue-chartjs";

    export default {
        name: "PieChart",
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
        watch: {
            chartdata() {
                this.renderChart(this.chartdata, this.options)
            }
        },
        data: () => ({}),
        mounted() {
            this.renderChart(this.chartdata, this.options)
        },
        methods: {}
    }
</script>

<style scoped>

</style>
