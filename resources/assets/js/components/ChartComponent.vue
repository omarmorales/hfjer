<script>
import { Bar, mixins } from 'vue-chartjs'

export default {
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
  extends: Bar,
  mixins: [mixins.reactiveProp],
  mounted () {
    // Overwriting base render method with actual data.
    this.renderChart(this.chartData,this.options)
  }
}
</script>
