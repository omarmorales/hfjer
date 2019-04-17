<script>
import { Bar } from 'vue-chartjs'

export default {
  extends: Bar,
  mounted () {
    // Overwriting base render method with actual data.
    this.renderChart({
      labels: ['>24'],
      datasets: [
        {
          label: 'Personas que bajaron 1 categoría',
          backgroundColor: '#2196F3',
          data: [1]
        }
      ]
    })
  }
}
</script>
