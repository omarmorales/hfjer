<script>
import { Pie } from 'vue-chartjs'

export default {
  extends: Pie,
  mounted () {
    // Overwriting base render method with actual data.
    this.renderChart({
      labels: ['Masculino', 'Femenino'],
      datasets: [
        {
          label: 'puntuación promedio',
          backgroundColor: ['#FB8C00','#C0C0C0'],
          data: [1,1]
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
