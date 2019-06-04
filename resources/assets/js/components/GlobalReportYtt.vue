<template>
    <div class="col-md-12">
        <population-global-report
            :gender="gender" 
            :total_beneficiaries_with_take_selected="total_beneficiaries_with_take_selected"
        />
        <age-group-global-report
            :age_group="age_group" 
        />
        <risk-level-global-report
            :risk_level="risk_level" 
        />
    </div>
</template>

<script>
    export default {
        props: {
            total_beneficiaries_with_take_selected: Array,
            age_group: Object,
            gender: Object,
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