<template>
    <div class="card">
        <div class="card-header">
            Progreso
        </div>
        <div class="card-body">
            <linechart-component v-if="loaded" :chartData="chartData" :options="chartOptions" :height="100"></linechart-component>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            evaluations: Array
        },
        data: () => ({
            loaded: false,
            testLabel: '',
            testData: '',
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
                    yAxes: [
                        {
                            ticks: {
                                beginAtZero: true,
                                // callback: function (value) { 
                                //     (Number.isInteger(value)) ? value : undefined  
                                // },
                            }
                        }
                    ]
                },
            }
        }),
        methods: {

        },
        created(){
            this.loaded = false
            let dataset = this.chartData.datasets.findIndex(
                dataset => dataset.label = 'Nivel de riesgo general'
            );
            axios.get('/api/beneficiary_by_folio/'+this.$route.params.user).then(({data}) => (
                this.chartData.labels = (data.group.evaluation == 'yttv1') ?  data.ytt1_evaluations.map(evaluation => 'Toma ' + (data.ytt1_evaluations.indexOf(evaluation)+1)) : data.ytt2_evaluations.map(evaluation => 'Toma ' + (data.ytt2_evaluations.indexOf(evaluation)+1)),
                this.chartData.datasets[dataset].data = (data.group.evaluation == 'yttv1') ?  data.ytt1_evaluations.map(evaluation => evaluation.risk_level) : data.ytt2_evaluations.map(evaluation => evaluation.risk_level),
                this.loaded = true
            ));
        }
    }
</script>

<style lang="scss" scoped>

</style>