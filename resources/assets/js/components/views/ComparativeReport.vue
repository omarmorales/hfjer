<template>
    <div class="container">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">Reporte comparativo</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <div class="row">
            <div class="col-md-12">
                <h3 class="font-weight-bold text-uppercase text-center">
                    <i class="fas fa-chart-bar"></i>
                    Reporte comparativo de {{ organization.name }}
                </h3>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Seleccionar grupo de personas beneficiarias</label>
                    <select class="form-control" id="group" v-model="group_selected" @change="getBeneficiaries()">
                        <option v-for="group in groups" :key="group.id" :value="group">{{ group.name }}</option>
                    </select>
                </div>
                <div class="form-group" v-show="group_selected">
                    <label for="">Versión de la herramienta</label>
                    <input type="text" :value="group_selected.evaluation" readonly class="form-control">
                </div>
                <div class="form-group" v-if="group_selected">
                    <label for="">Seleccionar toma 1</label>
                    <select class="form-control" id="take" v-model="take_selected_one" @change="handle_takes_selected()">
                        <option v-for="(take, index) in max_takes" :key="index" :value="take">{{ take }}</option>
                    </select>
                </div>
                <div class="form-group" v-if="group_selected">
                    <label for="">Seleccionar toma 2</label>
                    <select class="form-control" id="take" v-model="take_selected_two" @change="handle_takes_selected()">
                        <option v-for="(take, index) in max_takes" :key="index" :value="take">{{ take }}</option>
                    </select>
                </div>
                <div class="form-group" v-show="resultsBtn">
                    <button class="btn btn-primary" @click="showData">Obtener datos</button>
                </div>
            </div>
        </div>
        <div class="row" v-show="show_data">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <p class="font-weight-bold h2">{{ total_beneficiaries_with_take_selected.length }}</p>
                        <p>Población total</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <p class="font-weight-bold h2">{{ gender.female.length }}</p>
                        <p>Mujer(es)</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <p class="font-weight-bold h2">{{ gender.male.length }}</p>
                        <p>Hombre(s)</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <p class="font-weight-bold h2">{{ gender.other.length }}</p>
                        <p>Otro(s)</p>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Población desagregada por grupo etario
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Comparación nivel de riesgo general
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nivel</th>
                                        <th>Número (Toma 1)</th>
                                        <th>Número (Toma 2)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Bajo</th>
                                        <td>{{ risk_level.take_one.low.length }}</td>
                                        <td>{{ risk_level.take_two.low.length }}</td>
                                    </tr>
                                    <tr>
                                        <th>Medio</th>
                                        <td>{{ risk_level.take_one.medium.length }}</td>
                                        <td>{{ risk_level.take_two.medium.length }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alto</th>
                                        <td>{{ risk_level.take_one.high.length }}</td>
                                        <td>{{ risk_level.take_two.high.length }}</td>
                                    </tr>
                                    <tr>
                                        <th>Critico</th>
                                        <td>{{ risk_level.take_one.critical.length }}</td>
                                        <td>{{ risk_level.take_two.critical.length }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12" v-if="group_selected.evaluation == 'yttv1'">
                <div class="card">
                    <div class="card-header">
                        Comparación nivel de propensión a conductas violentas
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nivel</th>
                                        <th>Número (Toma 1)</th>
                                        <th>Número (Toma 2)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Bajo</th>
                                        <td>{{ propensity_level.take_one.low.length }}</td>
                                        <td>{{ propensity_level.take_two.low.length }}</td>
                                    </tr>
                                    <tr>
                                        <th>Medio</th>
                                        <td>{{ propensity_level.take_one.medium.length }}</td>
                                        <td>{{ propensity_level.take_two.medium.length }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alto</th>
                                        <td>{{ propensity_level.take_one.high.length }}</td>
                                        <td>{{ propensity_level.take_two.high.length }}</td>
                                    </tr>
                                    <tr>
                                        <th>Critico</th>
                                        <td>{{ propensity_level.take_one.critical.length }}</td>
                                        <td>{{ propensity_level.take_two.critical.length }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: () => ({
            loading: false,
            user: '',
            organization: '',
            groups: [],
            group_selected: '',
            resultsBtn: false,
            beneficiaries: [],
            beneficiaries_evaluations: [],
            take_selected_one: '',
            take_selected_two: '',
            max_takes: '',
            beneficiaries_takes: '',
            total_beneficiaries_with_take_selected: '',
            ages_of_beneficiaries_selected: '',
            risk_level_of_beneficiaries_selected_take_one: '',
            risk_level_of_beneficiaries_selected_take_two: '',
            propensity_level_of_beneficiaries_selected_take_one: '',
            propensity_level_of_beneficiaries_selected_take_two: '',
            show_data: false,
            gender: {
                male: '',
                female: '',
                other: ''
            },
            age_group: {
                less_than_11: '',
                between_12_and_15: '',
                between_16_and_19: '',
                between_20_and_23: '',
                more_than_24: ''
            },
            risk_level: {
                take_one: {
                    low: '',
                    medium: '',
                    high: '',
                    critical: ''
                },
                take_two: {
                    low: '',
                    medium: '',
                    high: '',
                    critical: ''
                }
            },
            propensity_level: {
                take_one: {
                    low: '',
                    medium: '',
                    high: '',
                    critical: ''
                },
                take_two: {
                    low: '',
                    medium: '',
                    high: '',
                    critical: ''
                }
            },
        }),
        methods:{
            handle_takes_selected(){
                if(this.take_selected_one && this.take_selected_two){
                    if(this.take_selected_one < this.take_selected_two){
                        this.resultsBtn = true;
                    } else {
                       toast({type: 'error',title: 'La toma 1 no puede ser mayor o igual que la toma 2.'});
                       this.resultsBtn = false;
                       this.show_data = false;
                    }
                    
                } else {
                    toast({type: 'info',title: 'Selecciona dos tomas para comparar.'})
                }
            },
            showData(){
                toast({type: 'success',title: 'Datos obtenidos correctamente.'})
                if (this.group_selected.evaluation == "yttv1"){
                    this.show_data = true;
                    this.total_beneficiaries_with_take_selected = this.beneficiaries.filter(beneficiary => beneficiary.ytt1_evaluations.length >= this.take_selected_two);
                    this.ages_of_beneficiaries_selected = this.total_beneficiaries_with_take_selected.map(beneficiary => beneficiary.ytt1_evaluations[this.take_selected_two-1].age);
                    this.gender.male = this.total_beneficiaries_with_take_selected.filter(beneficiary => beneficiary.gender == "masculino");
                    this.gender.female = this.total_beneficiaries_with_take_selected.filter(beneficiary => beneficiary.gender == "femenino");
                    this.gender.other = this.total_beneficiaries_with_take_selected.filter(beneficiary => beneficiary.gender == "otro");
                    this.age_group.less_than_11 = this.ages_of_beneficiaries_selected.filter(age => age < 11);
                    this.age_group.between_12_and_15 = this.ages_of_beneficiaries_selected.filter(age => age >= 12 && age <= 15);
                    this.age_group.between_16_and_19 = this.ages_of_beneficiaries_selected.filter(age => age >= 16 && age <= 19);
                    this.age_group.between_20_and_23 = this.ages_of_beneficiaries_selected.filter(age => age >= 20 && age <= 23);
                    this.age_group.more_than_24 = this.ages_of_beneficiaries_selected.filter(age => age >= 24);
                    this.risk_level_of_beneficiaries_selected_take_one = this.total_beneficiaries_with_take_selected.map(beneficiary => beneficiary.ytt1_evaluations[this.take_selected_one-1].risk_level);
                    this.risk_level_of_beneficiaries_selected_take_two = this.total_beneficiaries_with_take_selected.map(beneficiary => beneficiary.ytt1_evaluations[this.take_selected_two-1].risk_level);
                    
                    this.risk_level.take_one.low = this.risk_level_of_beneficiaries_selected_take_one.filter(risk_level => risk_level < 2.5);
                    this.risk_level.take_one.medium = this.risk_level_of_beneficiaries_selected_take_one.filter(risk_level => risk_level >= 2.5 && risk_level <= 5);
                    this.risk_level.take_one.high = this.risk_level_of_beneficiaries_selected_take_one.filter(risk_level => risk_level >= 5.1 && risk_level <= 7.5);
                    this.risk_level.take_one.critical = this.risk_level_of_beneficiaries_selected_take_one.filter(risk_level => risk_level >= 7.6);

                    this.risk_level.take_two.low = this.risk_level_of_beneficiaries_selected_take_two.filter(risk_level => risk_level < 2.5);
                    this.risk_level.take_two.medium = this.risk_level_of_beneficiaries_selected_take_two.filter(risk_level => risk_level >= 2.5 && risk_level <= 5);
                    this.risk_level.take_two.high = this.risk_level_of_beneficiaries_selected_take_two.filter(risk_level => risk_level >= 5.1 && risk_level <= 7.5);
                    this.risk_level.take_two.critical = this.risk_level_of_beneficiaries_selected_take_two.filter(risk_level => risk_level >= 7.6);

                    this.propensity_level_of_beneficiaries_selected_take_one = this.total_beneficiaries_with_take_selected.map(beneficiary => beneficiary.ytt1_evaluations[this.take_selected_one-1].propensity_level);
                    this.propensity_level_of_beneficiaries_selected_take_two = this.total_beneficiaries_with_take_selected.map(beneficiary => beneficiary.ytt1_evaluations[this.take_selected_two-1].propensity_level);
                    
                    this.propensity_level.take_one.low = this.propensity_level_of_beneficiaries_selected_take_one.filter(propensity_level => propensity_level < 2.5);
                    this.propensity_level.take_one.medium = this.propensity_level_of_beneficiaries_selected_take_one.filter(propensity_level => propensity_level >= 2.5 && propensity_level <= 5);
                    this.propensity_level.take_one.high = this.propensity_level_of_beneficiaries_selected_take_one.filter(propensity_level => propensity_level >= 5.1 && propensity_level <= 7.5);
                    this.propensity_level.take_one.critical = this.propensity_level_of_beneficiaries_selected_take_one.filter(propensity_level => propensity_level >= 7.6);

                    this.propensity_level.take_two.low = this.propensity_level_of_beneficiaries_selected_take_two.filter(propensity_level => propensity_level < 2.5);
                    this.propensity_level.take_two.medium = this.propensity_level_of_beneficiaries_selected_take_two.filter(propensity_level => propensity_level >= 2.5 && propensity_level <= 5);
                    this.propensity_level.take_two.high = this.propensity_level_of_beneficiaries_selected_take_two.filter(propensity_level => propensity_level >= 5.1 && propensity_level <= 7.5);
                    this.propensity_level.take_two.critical = this.propensity_level_of_beneficiaries_selected_take_two.filter(propensity_level => propensity_level >= 7.6);
                } else if (this.group_selected.evaluation == "yttv2"){
                    this.show_data = true;
                    this.total_beneficiaries_with_take_selected = this.beneficiaries.filter(beneficiary => beneficiary.ytt2_evaluations.length >= this.take_selected_two);
                    this.ages_of_beneficiaries_selected = this.total_beneficiaries_with_take_selected.map(beneficiary => beneficiary.ytt2_evaluations[this.take_selected_two-1].age);
                    this.gender.male = this.total_beneficiaries_with_take_selected.filter(beneficiary => beneficiary.gender == "masculino");
                    this.gender.female = this.total_beneficiaries_with_take_selected.filter(beneficiary => beneficiary.gender == "femenino");
                    this.gender.other = this.total_beneficiaries_with_take_selected.filter(beneficiary => beneficiary.gender == "otro");
                    this.age_group.less_than_11 = this.ages_of_beneficiaries_selected.filter(age => age < 11);
                    this.age_group.between_12_and_15 = this.ages_of_beneficiaries_selected.filter(age => age >= 12 && age <= 15);
                    this.age_group.between_16_and_19 = this.ages_of_beneficiaries_selected.filter(age => age >= 16 && age <= 19);
                    this.age_group.between_20_and_23 = this.ages_of_beneficiaries_selected.filter(age => age >= 20 && age <= 23);
                    this.age_group.more_than_24 = this.ages_of_beneficiaries_selected.filter(age => age >= 24);
                    this.risk_level_of_beneficiaries_selected_take_one = this.total_beneficiaries_with_take_selected.map(beneficiary => beneficiary.ytt2_evaluations[this.take_selected_one-1].risk_level);
                    this.risk_level_of_beneficiaries_selected_take_two = this.total_beneficiaries_with_take_selected.map(beneficiary => beneficiary.ytt2_evaluations[this.take_selected_two-1].risk_level);
                    
                    this.risk_level.take_one.low = this.risk_level_of_beneficiaries_selected_take_one.filter(risk_level => risk_level < 7);
                    this.risk_level.take_one.medium = this.risk_level_of_beneficiaries_selected_take_one.filter(risk_level => risk_level >= 8 && risk_level <= 13);
                    this.risk_level.take_one.high = this.risk_level_of_beneficiaries_selected_take_one.filter(risk_level => risk_level >= 14 && risk_level <= 20);
                    this.risk_level.take_one.critical = this.risk_level_of_beneficiaries_selected_take_one.filter(risk_level => risk_level >= 21);

                    this.risk_level.take_two.low = this.risk_level_of_beneficiaries_selected_take_two.filter(risk_level => risk_level < 7);
                    this.risk_level.take_two.medium = this.risk_level_of_beneficiaries_selected_take_two.filter(risk_level => risk_level >= 8 && risk_level <= 13);
                    this.risk_level.take_two.high = this.risk_level_of_beneficiaries_selected_take_two.filter(risk_level => risk_level >= 14 && risk_level <= 20);
                    this.risk_level.take_two.critical = this.risk_level_of_beneficiaries_selected_take_two.filter(risk_level => risk_level >= 21);
                }
            },
            getBeneficiaries(){
                if(this.group_selected) {
                    this.beneficiaries = this.group_selected.beneficiaries.filter(beneficiary => beneficiary.birthdate !== null);
                    if(this.beneficiaries.length > 0){
                        if(this.group_selected.evaluation == "yttv2"){
                            this.beneficiaries_takes = this.beneficiaries.map(beneficiary => beneficiary.ytt2_evaluations.length);
                            this.max_takes = Math.max(...this.beneficiaries_takes);
                        } else if (this.group_selected.evaluation == "yttv1"){
                            this.beneficiaries_takes = this.beneficiaries.map(beneficiary => beneficiary.ytt1_evaluations.length);
                            this.max_takes = Math.max(...this.beneficiaries_takes);
                        }
                    } else{
                        toast({
                        type: 'error',
                        title: 'No se han creado tomas en este grupo.'
                        })
                        this.max_takes = '';
                        this.beneficiaries= '';
                        this.beneficiaries_takes= [];
                        this.resultsBtn = false;
                        this.take_selected_one = '';
                        this.take_selected_two = '';
                    }
                    
                    
                    }
            },
            loadUser(){
                this.$Progress.start();
                this.loading = true;
                axios.get("api/profile").then(({ data }) => (
                    this.user = data,
                    this.organization = data.organization,
                    this.groups = data.organization.groups,
                    this.$Progress.finish(),
                    this.loading = false
                )).catch(() => {
                    this.loading = false;
                    this.$Progress.fail();
                });
            }
        },
        created(){
            this.loadUser();
        }
    }
</script>

<style lang="scss" scoped>

</style>