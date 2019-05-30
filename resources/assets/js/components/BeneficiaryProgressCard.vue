<template lang="html">
  <div class="card">
    <div class="card-body">
      <linechart-component v-if="loaded" :chartData="chartData" :options="chartOptions" :height="100"></linechart-component>
    </div>
  </div>
</template>

<script>
export default {
  data(){
    return{
      loaded: false,
      dates: [],
      risk_levels: [],
      chartData: {
        labels: [],
        datasets: [
          {
            label: 'Nivel de riesgo general',
            fill: false,
            borderColor: '#36a2eb',
            backgroundColor: '#36a2eb',
            data: [1,2],
          }
        ]
      },
      chartOptions: {
        legend: {
          position: 'bottom'
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
    }
  },
  mounted(){
    this.loaded = false
    axios.get(`/api/yttevaluationdate/${this.$route.params.f}`).then(({data}) => (
        this.chartData.labels = data.map(date => date.created_at),
        this.chartData.datasets[0].data = data.map(result => result.risk_level),
        this.loaded = true
    )).catch(err => {
      this.errorMessage = err.response.data.error
      this.showError = true
    })
  }
}
</script>

<style lang="css" scoped>
</style>
