<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <p class="card-title">Población desagregada por grupo etario</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                        <th>Grupo etario</th>
                                        <th>Número</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ "<11" }}</td>
                                            <td>{{ chartData.datasets[0].data[0] }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ "12-15" }}</td>
                                            <td>{{ chartData.datasets[0].data[1] }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ "16-19" }}</td>
                                            <td>{{ chartData.datasets[0].data[2] }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ "20-23" }}</td>
                                            <td>{{ chartData.datasets[0].data[3] }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ ">=24" }}</td>
                                            <td>{{ chartData.datasets[0].data[4] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <piechart-component v-if="loaded" :chartData="chartData" :options="chartOptions" :height="250" />
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
            age_group: Object,
            chartData: Object,
            chartOptions: Object,
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