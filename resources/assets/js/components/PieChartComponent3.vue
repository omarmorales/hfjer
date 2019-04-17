<script>
import { Pie } from 'vue-chartjs'

export default {
  extends: Pie,
  mounted () {
    // Overwriting base render method with actual data.
    this.renderChart({
      labels: ['Personas que bajaron 1 categoría'],
      datasets: [
        {
          label: 'Puntuación Promedio',
          backgroundColor: '#4CAF50',
          data: [1]
        }
      ]
    },{
      legend: {
        position: 'bottom'
      }
    })
  }
}
</script>
