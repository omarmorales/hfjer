<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <p class="card-title">Resultados globales</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3" v-if="group_selected.evaluation == 'yttv1'">
                            <chart-component v-if="loaded" :chartData="chartDataGR" :options="chartOptionsGR" :height="100" />
                        </div>
                        <div :class="{ 'col-md-12' : group_selected.evaluation == 'yttv1', 'col-md-6' : group_selected.evaluation == 'yttv2' }">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th class="text-center" colspan="2">Nivel de riesgo</th>
                                            <th v-if="group_selected.evaluation == 'yttv1'" class="text-center" colspan="2">Nivel de exposición</th>
                                            <th v-if="group_selected.evaluation == 'yttv1'" class="text-center" colspan="2">Nivel de propensión</th>
                                        </tr>
                                        <tr>
                                            <th>Nivel</th>
                                            <th>Número</th>
                                            <th>Porcentaje del total</th>
                                            <th v-if="group_selected.evaluation == 'yttv1'">Número</th>
                                            <th v-if="group_selected.evaluation == 'yttv1'">Porcentaje del total</th>
                                            <th v-if="group_selected.evaluation == 'yttv1'">Número</th>
                                            <th v-if="group_selected.evaluation == 'yttv1'">Porcentaje del total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Bajo</td>
                                            <td v-if="group_selected.evaluation == 'yttv1'">{{ chartDataGR.datasets[0].data[0] }}</td>
                                            <td v-if="group_selected.evaluation == 'yttv1'">{{ chartDataGR.datasets[0].data[0] / (chartDataGR.datasets[0].data[0] + chartDataGR.datasets[1].data[0] + chartDataGR.datasets[2].data[0] + chartDataGR.datasets[3].data[0]) | myNumberPercentage}}</td>
                                            <td v-if="group_selected.evaluation == 'yttv2'">{{ chartDataRL.datasets[0].data[0] }}</td>
                                            <td v-if="group_selected.evaluation == 'yttv2'">{{ chartDataRL.datasets[0].data[0] / (chartDataRL.datasets[0].data[0] + chartDataRL.datasets[1].data[0] + chartDataRL.datasets[2].data[0] + chartDataRL.datasets[3].data[0]) | myNumberPercentage}}</td>
                                            <td v-if="group_selected.evaluation == 'yttv1'">{{ chartDataGR.datasets[0].data[1] }}</td>
                                            <td v-if="group_selected.evaluation == 'yttv1'">{{ chartDataGR.datasets[0].data[1] / (chartDataGR.datasets[0].data[1] + chartDataGR.datasets[1].data[1] + chartDataGR.datasets[2].data[1] + chartDataGR.datasets[3].data[1]) | myNumberPercentage}}</td>
                                            <td v-if="group_selected.evaluation == 'yttv1'">{{ chartDataGR.datasets[0].data[2] }}</td>
                                            <td v-if="group_selected.evaluation == 'yttv1'">{{ chartDataGR.datasets[0].data[2] / (chartDataGR.datasets[0].data[2] + chartDataGR.datasets[1].data[2] + chartDataGR.datasets[2].data[2] + chartDataGR.datasets[3].data[2]) | myNumberPercentage}}</td>
                                        </tr>
                                        <tr>
                                            <td>Medio</td>
                                            <td v-if="group_selected.evaluation == 'yttv1'">{{ chartDataGR.datasets[1].data[0] }}</td>
                                            <td v-if="group_selected.evaluation == 'yttv1'">{{ chartDataGR.datasets[1].data[0] / (chartDataGR.datasets[0].data[0] + chartDataGR.datasets[1].data[0] + chartDataGR.datasets[2].data[0] + chartDataGR.datasets[3].data[0]) | myNumberPercentage}}</td>
                                            <td v-if="group_selected.evaluation == 'yttv2'">{{ chartDataRL.datasets[1].data[0] }}</td>
                                            <td v-if="group_selected.evaluation == 'yttv2'">{{ chartDataRL.datasets[1].data[0] / (chartDataRL.datasets[0].data[0] + chartDataRL.datasets[1].data[0] + chartDataRL.datasets[2].data[0] + chartDataRL.datasets[3].data[0]) | myNumberPercentage}}</td>
                                            <td v-if="group_selected.evaluation == 'yttv1'">{{ chartDataGR.datasets[1].data[1] }}</td>
                                            <td v-if="group_selected.evaluation == 'yttv1'">{{ chartDataGR.datasets[1].data[1] / (chartDataGR.datasets[0].data[1] + chartDataGR.datasets[1].data[1] + chartDataGR.datasets[2].data[1] + chartDataGR.datasets[3].data[1]) | myNumberPercentage}}</td>
                                            <td v-if="group_selected.evaluation == 'yttv1'">{{ chartDataGR.datasets[1].data[2] }}</td>
                                            <td v-if="group_selected.evaluation == 'yttv1'">{{ chartDataGR.datasets[1].data[2] / (chartDataGR.datasets[0].data[2] + chartDataGR.datasets[1].data[2] + chartDataGR.datasets[2].data[2] + chartDataGR.datasets[3].data[2]) | myNumberPercentage}}</td>
                                        </tr>
                                        <tr>
                                            <td>Alto</td>
                                            <td v-if="group_selected.evaluation == 'yttv1'">{{ chartDataGR.datasets[2].data[0] }}</td>
                                            <td v-if="group_selected.evaluation == 'yttv1'">{{ chartDataGR.datasets[2].data[0] / (chartDataGR.datasets[0].data[0] + chartDataGR.datasets[1].data[0] + chartDataGR.datasets[2].data[0] + chartDataGR.datasets[3].data[0]) | myNumberPercentage}}</td>
                                            <td v-if="group_selected.evaluation == 'yttv2'">{{ chartDataRL.datasets[2].data[0] }}</td>
                                            <td v-if="group_selected.evaluation == 'yttv2'">{{ chartDataRL.datasets[2].data[0] / (chartDataRL.datasets[0].data[0] + chartDataRL.datasets[1].data[0] + chartDataRL.datasets[2].data[0] + chartDataRL.datasets[3].data[0]) | myNumberPercentage}}</td>
                                            <td v-if="group_selected.evaluation == 'yttv1'">{{ chartDataGR.datasets[2].data[1] }}</td>
                                            <td v-if="group_selected.evaluation == 'yttv1'">{{ chartDataGR.datasets[2].data[1] / (chartDataGR.datasets[0].data[1] + chartDataGR.datasets[1].data[1] + chartDataGR.datasets[2].data[1] + chartDataGR.datasets[3].data[1]) | myNumberPercentage}}</td>
                                            <td v-if="group_selected.evaluation == 'yttv1'">{{ chartDataGR.datasets[2].data[2] }}</td>
                                            <td v-if="group_selected.evaluation == 'yttv1'">{{ chartDataGR.datasets[2].data[2] / (chartDataGR.datasets[0].data[2] + chartDataGR.datasets[1].data[2] + chartDataGR.datasets[2].data[2] + chartDataGR.datasets[3].data[2]) | myNumberPercentage}}</td>
                                        </tr>
                                        <tr>
                                            <td>Critico</td>
                                            <td v-if="group_selected.evaluation == 'yttv1'">{{ chartDataGR.datasets[3].data[0] }}</td>
                                            <td v-if="group_selected.evaluation == 'yttv1'">{{ chartDataGR.datasets[3].data[0] / (chartDataGR.datasets[0].data[0] + chartDataGR.datasets[1].data[0] + chartDataGR.datasets[2].data[0] + chartDataGR.datasets[3].data[0]) | myNumberPercentage}}</td>
                                            <td v-if="group_selected.evaluation == 'yttv2'">{{ chartDataRL.datasets[3].data[0] }}</td>
                                            <td v-if="group_selected.evaluation == 'yttv2'">{{ chartDataRL.datasets[3].data[0] / (chartDataRL.datasets[0].data[0] + chartDataRL.datasets[1].data[0] + chartDataRL.datasets[2].data[0] + chartDataRL.datasets[3].data[0]) | myNumberPercentage}}</td>
                                            <td v-if="group_selected.evaluation == 'yttv1'">{{ chartDataGR.datasets[3].data[1] }}</td>
                                            <td v-if="group_selected.evaluation == 'yttv1'">{{ chartDataGR.datasets[3].data[1] / (chartDataGR.datasets[0].data[1] + chartDataGR.datasets[1].data[1] + chartDataGR.datasets[2].data[1] + chartDataGR.datasets[3].data[1]) | myNumberPercentage}}</td>
                                            <td v-if="group_selected.evaluation == 'yttv1'">{{ chartDataGR.datasets[3].data[2] }}</td>
                                            <td v-if="group_selected.evaluation == 'yttv1'">{{ chartDataGR.datasets[3].data[2] / (chartDataGR.datasets[0].data[2] + chartDataGR.datasets[1].data[2] + chartDataGR.datasets[2].data[2] + chartDataGR.datasets[3].data[2]) | myNumberPercentage}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6" v-if="group_selected.evaluation == 'yttv2'">
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
            loaded: Boolean,
            group_selected: Object,
            chartDataGR: Object,
            chartOptionsGR: Object,
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