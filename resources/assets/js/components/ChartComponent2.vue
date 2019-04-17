<script>
import { Bar } from 'vue-chartjs'

export default {
  extends: Bar,
  mounted () {
    // Overwriting base render method with actual data.
    this.renderChart({
      labels: ['Personas que bajaron 1 categoría'],
      datasets: [
        {
          label: 'Hombres',
          backgroundColor: '#FB8C00',
          data: [1]
        }
      ]
    })
  }
}
</script>
