<script>
import { Bar } from 'vue-chartjs'

export default {
  extends: Bar,
  mounted () {
    // Overwriting base render method with actual data.
    this.renderChart(
      {
        labels: ['Alto','Crítico'],
        datasets: [
          {
            label: 'Puntuación Promedio',
            backgroundColor: '#03A9F4',
            data: [1,1]
          }
        ]
      },{
        legend: {
          position: 'top'
        },
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true,
              callback: function (value) { if (Number.isInteger(value)) { return value; } },
              stepSize: 1
            }
          }]
        },
      }
    )
  }
}
</script>
