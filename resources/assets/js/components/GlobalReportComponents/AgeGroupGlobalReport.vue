<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <p class="card-title">Población desagregada por grupo etario</p>
                </div>
                <div class="card-body">
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
                                    <td>{{ age_group.less_than_11.length }}</td>
                                </tr>
                                <tr>
                                    <td>{{ "12-15" }}</td>
                                    <td>{{ age_group.between_12_and_15.length }}</td>
                                </tr>
                                <tr>
                                    <td>{{ "16-19" }}</td>
                                    <td>{{ age_group.between_16_and_19.length }}</td>
                                </tr>
                                <tr>
                                    <td>{{ "20-23" }}</td>
                                    <td>{{ age_group.between_20_and_23.length }}</td>
                                </tr>
                                <tr>
                                    <td>{{ ">=24" }}</td>
                                    <td>{{ age_group.more_than_24.length }}</td>
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
            age_group: Object,
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