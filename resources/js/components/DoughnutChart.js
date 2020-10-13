import { Doughnut, mixins } from 'vue-chartjs'
const { reactiveProp } = mixins

export default {
    extends: Doughnut,
    mixins: [reactiveProp],
    data () {
        return {
            options: {
                legend: {display: !0, position: 'bottom', labels: { fontColor: '#7F8FA4', usePointStyle: !0 }},
                responsive: true,
                maintainAspectRatio: false
            }
        }
    },
    mounted () {
        this.renderChart(this.chartData, this.options)
    }
}