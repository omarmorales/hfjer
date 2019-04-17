<script>
import { Pie } from 'vue-chartjs'

export default {
  extends: Pie,
  mounted () {
    // Overwriting base render method with actual data.
    this.renderChart({
      labels: ['>24'],
      datasets: [
        {
          label: 'puntuación promedio',
          backgroundColor: ['#2196F3','#C0C0C0'],
          data: [2]
        }
      ]
    },{
      legend: {
        position: 'left'
      }
    })
  }
}
</script>
