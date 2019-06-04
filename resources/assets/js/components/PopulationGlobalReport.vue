<template>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <p class="font-weight-bolder h2">{{ total_beneficiaries_with_take_selected.length }}</p>
                    <p>Población total</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <p class="font-weight-bolder h2">{{ gender.female.length }}</p>
                    <p>Mujer(es)</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <p class="font-weight-bolder h2">{{ gender.male.length }}</p>
                    <p>Hombre(s)</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <p class="font-weight-bolder h2">{{ gender.other.length }}</p>
                    <p>Otro(s)</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            total_beneficiaries_with_take_selected: Array,
            gender: Object,
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