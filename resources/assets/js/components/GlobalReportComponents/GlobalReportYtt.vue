<template>
    <div class="col-md-12">
        <population-global-report
            :gender="gender" 
            :total_beneficiaries_with_take_selected="total_beneficiaries_with_take_selected"
        />
        <age-group-global-report
            :age_group="age_group"
            :chartData="chartData"
            :chartOptions="chartOptions"
            :loaded="loaded"
        />
        <risk-level-global-report
            :risk_level="risk_level" 
            :chartDataRL="chartDataRL"
            :chartOptionsRL="chartOptionsRL"
            :chartDataGR="chartDataGR"
            :chartOptionsGR="chartOptionsGR"
            :loaded="loaded"
            :group_selected="group_selected"
        />
        <results-by-gender
            :risk_level="risk_level" 
            :chartDataRLG="chartDataRLG"
            :chartOptionsRLG="chartOptionsRLG"
            :chartDataELG="chartDataELG"
            :chartOptionsELG="chartOptionsELG"
            :loaded="loaded"
            :group_selected="group_selected"
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
            chartData: Object,
            chartOptions: Object,
            chartDataRL: Object,
            chartOptionsRL: Object,
            chartDataRLG: Object,
            chartOptionsRLG: Object,
            chartDataELG: Object,
            chartOptionsELG: Object,
            chartDataGR: Object,
            chartOptionsGR: Object,
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