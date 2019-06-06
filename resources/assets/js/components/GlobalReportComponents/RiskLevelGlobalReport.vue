<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <p class="card-title">Nivel de riesgo</p>
                </div>
                <div class="card-body">
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
                                    <td>{{ risk_level.low.length }}</td>
                                </tr>
                                <tr>
                                    <td>Medio</td>
                                    <td>{{ risk_level.medium.length }}</td>
                                </tr>
                                <tr>
                                    <td>Alto</td>
                                    <td>{{ risk_level.high.length }}</td>
                                </tr>
                                <tr>
                                    <td>Critico</td>
                                    <td>{{ risk_level.critical.length }}</td>
                                </tr>
                            </tbody>
                        </table>
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