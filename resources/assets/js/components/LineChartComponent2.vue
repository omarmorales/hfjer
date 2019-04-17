<script>
import { Line } from 'vue-chartjs'

export default {
  extends: Line,
  mounted () {
    // Overwriting base render method with actual data.
    this.renderChart(
      {
        labels: ['07/02/2019','08/02/2019'],
        datasets: [
          {
            label: 'puntuación promedio',
            backgroundColor: '#03A9F4',
            data: [7.82,3.77]
          }
        ]
      },{
        legend: {
          position: 'bottom'
        },
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true,
              callback: function (value) { if (Number.isInteger(value)) { return value; } },
              stepSize: 2
            }
          }]
        },
      }
    )
  }
}
</script>
