<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <p class="card-title">
                        Resultados por género
                    </p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th class="text-center" colspan="3">Nivel de riesgo</th>
                                            <th v-if="group_selected.evaluation == 'yttv1'" class="text-center" colspan="3">Nivel de exposición</th>
                                            <th v-if="group_selected.evaluation == 'yttv1'" class="text-center" colspan="3">Nivel de propensión</th>
                                        </tr>
                                        <tr>
                                            <th>Nivel</th>
                                            <th>M</th>
                                            <th>H</th>
                                            <th>O</th>
                                            <th v-if="group_selected.evaluation == 'yttv1'">M</th>
                                            <th v-if="group_selected.evaluation == 'yttv1'">H</th>
                                            <th v-if="group_selected.evaluation == 'yttv1'">O</th>
                                            <th v-if="group_selected.evaluation == 'yttv1'">M</th>
                                            <th v-if="group_selected.evaluation == 'yttv1'">H</th>
                                            <th v-if="group_selected.evaluation == 'yttv1'">O</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Bajo</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td v-if="group_selected.evaluation == 'yttv1'"></td>
                                            <td v-if="group_selected.evaluation == 'yttv1'"></td>
                                            <td v-if="group_selected.evaluation == 'yttv1'"></td>
                                            <td v-if="group_selected.evaluation == 'yttv1'"></td>
                                            <td v-if="group_selected.evaluation == 'yttv1'"></td>
                                            <td v-if="group_selected.evaluation == 'yttv1'"></td>
                                        </tr>
                                        <tr>
                                            <td>Medio</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td v-if="group_selected.evaluation == 'yttv1'"></td>
                                            <td v-if="group_selected.evaluation == 'yttv1'"></td>
                                            <td v-if="group_selected.evaluation == 'yttv1'"></td>
                                            <td v-if="group_selected.evaluation == 'yttv1'"></td>
                                            <td v-if="group_selected.evaluation == 'yttv1'"></td>
                                            <td v-if="group_selected.evaluation == 'yttv1'"></td>
                                        </tr>
                                        <tr>
                                            <td>Alto</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td v-if="group_selected.evaluation == 'yttv1'"></td>
                                            <td v-if="group_selected.evaluation == 'yttv1'"></td>
                                            <td v-if="group_selected.evaluation == 'yttv1'"></td>
                                            <td v-if="group_selected.evaluation == 'yttv1'"></td>
                                            <td v-if="group_selected.evaluation == 'yttv1'"></td>
                                            <td v-if="group_selected.evaluation == 'yttv1'"></td>
                                        </tr>
                                        <tr>
                                            <td>Crítico</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td v-if="group_selected.evaluation == 'yttv1'"></td>
                                            <td v-if="group_selected.evaluation == 'yttv1'"></td>
                                            <td v-if="group_selected.evaluation == 'yttv1'"></td>
                                            <td v-if="group_selected.evaluation == 'yttv1'"></td>
                                            <td v-if="group_selected.evaluation == 'yttv1'"></td>
                                            <td v-if="group_selected.evaluation == 'yttv1'"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <radarchart-component v-if="loaded" :chartData="chartDataRLG" :options="chartOptionsRLG" :height="250" />
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
            chartDataRLG: Object,
            chartOptionsRLG: Object,
            loaded: Boolean,
            group_selected: Object
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