<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <p class="card-title">Nivel de riesgo</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nivel</th>
                                            <th>Número</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Bajo</td>
                                            <td>{{ chartDataRL.datasets[0].data[0] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Medio</td>
                                            <td>{{ chartDataRL.datasets[0].data[1] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Alto</td>
                                            <td>{{ chartDataRL.datasets[0].data[2] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Critico</td>
                                            <td>{{ chartDataRL.datasets[0].data[3] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <chart-component v-if="loaded" :chartData="chartDataRL" :options="chartOptionsRL" :height="250" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            risk_level: Object,
            chartDataRL: Object,
            chartOptionsRL: Object,
            loaded: Boolean
        },
        data: () => ({
            
        }),
        methods: {
            
        },
        created(){
            
        }
    }
</script>

<style lang="scss" scoped>

</style>