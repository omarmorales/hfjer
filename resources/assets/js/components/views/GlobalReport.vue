<template>
  <div class="container">
    <div class="row content-header" v-if="loading" style="height: 100vh">
      <div class="col-md-12 text-center">
        <p>
          <i class="fas fa-spinner fa-pulse fa-4x"></i>
        </p>
        <p class="h4">Cargando...</p>
      </div>
    </div>
    <div v-else>
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item active">Reporte global</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <div class="row">
        <div class="col-md-12">
          <h3 class="font-weight-bolder text-uppercase text-center">
            <i class="fas fa-chart-bar"></i>
            Reporte global de {{ user.organization.name }}
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
            <label for="">Seleccionar toma</label>
            <select class="form-control" id="take" v-model="take_selected" @change="showBtn()">
              <option v-for="(take, index) in max_takes" :key="index" :value="take">{{ take }}</option>
            </select>
          </div>
          <div class="form-group" v-show="resultsBtn">
            <button class="btn btn-primary" @click="showData">Obtener datos</button>
          </div>
        </div>
      </div>
      <div class="row">
        <global-report-ytt
          v-if="yttv1_data_selected == true || yttv2_data_selected == true"
          :total_beneficiaries_with_take_selected="total_beneficiaries_with_take_selected"
          :age_group="age_group"
          :gender="gender"
          :risk_level="risk_level"
        />

      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data(){
      return{
        yttv1_data_selected: false,
        yttv2_data_selected: false,
        resultsBtn: false,
        loading: false,
        groups: [],
        max_takes: '',
        take_selected: '',
        group_selected: '',
        user: '',
        beneficiaries: '',
        beneficiaries_takes: [],
        total_beneficiaries_with_take_selected: '',
        ages_of_beneficiaries_selected: '',
        risk_level_of_beneficiaries_selected: '',
        age_group: {
            less_than_11: '',
            between_12_and_15: '',
            between_16_and_19: '',
            between_20_and_23: '',
            more_than_24: ''
        },

        gender: {
            male: '',
            female: '',
            other: ''
        },

        risk_level: {
            low: '',
            medium: '',
            high: '',
            critical: ''
        },
      }
    },
    methods:{
      showData(){
        if (this.group_selected.evaluation == "yttv2"){
          this.yttv1_data_selected = false;
          this.yttv2_data_selected = true;

          this.total_beneficiaries_with_take_selected = this.beneficiaries.filter(beneficiary => beneficiary.ytt2_evaluations.length >= this.take_selected);
          this.ages_of_beneficiaries_selected = this.total_beneficiaries_with_take_selected.map(beneficiary => beneficiary.ytt2_evaluations[this.take_selected-1].age);
          this.risk_level_of_beneficiaries_selected = this.total_beneficiaries_with_take_selected.map(beneficiary => beneficiary.ytt2_evaluations[this.take_selected-1].risk_level);

          this.age_group.less_than_11 = this.ages_of_beneficiaries_selected.filter(age => age < 11);
          this.age_group.between_12_and_15 = this.ages_of_beneficiaries_selected.filter(age => age >= 12 && age <= 15);
          this.age_group.between_16_and_19 = this.ages_of_beneficiaries_selected.filter(age => age >= 16 && age <= 19);
          this.age_group.between_20_and_23 = this.ages_of_beneficiaries_selected.filter(age => age >= 20 && age <= 23);
          this.age_group.more_than_24 = this.ages_of_beneficiaries_selected.filter(age => age >= 24);

          this.gender.male = this.total_beneficiaries_with_take_selected.filter(beneficiary => beneficiary.gender == "masculino");
          this.gender.female = this.total_beneficiaries_with_take_selected.filter(beneficiary => beneficiary.gender == "femenino");
          this.gender.other = this.total_beneficiaries_with_take_selected.filter(beneficiary => beneficiary.gender == "otro");

          this.risk_level.low = this.risk_level_of_beneficiaries_selected.filter(risk_level => risk_level < 7);
          this.risk_level.medium = this.risk_level_of_beneficiaries_selected.filter(risk_level => risk_level >= 8 && risk_level <= 13);
          this.risk_level.high = this.risk_level_of_beneficiaries_selected.filter(risk_level => risk_level >= 14 && risk_level <= 20);
          this.risk_level.critical = this.risk_level_of_beneficiaries_selected.filter(risk_level => risk_level >= 21);
        } else if (this.group_selected.evaluation == "yttv1"){
          this.yttv1_data_selected = true;
          this.yttv2_data_selected = false;

          this.total_beneficiaries_with_take_selected = this.beneficiaries.filter(beneficiary => beneficiary.ytt1_evaluations.length >= this.take_selected);
          this.ages_of_beneficiaries_selected = this.total_beneficiaries_with_take_selected.map(beneficiary => beneficiary.ytt1_evaluations[this.take_selected-1].age);
          this.risk_level_of_beneficiaries_selected = this.total_beneficiaries_with_take_selected.map(beneficiary => beneficiary.ytt1_evaluations[this.take_selected-1].risk_level);

          this.age_group.less_than_11 = this.ages_of_beneficiaries_selected.filter(age => age < 11);
          this.age_group.between_12_and_15 = this.ages_of_beneficiaries_selected.filter(age => age >= 12 && age <= 15);
          this.age_group.between_16_and_19 = this.ages_of_beneficiaries_selected.filter(age => age >= 16 && age <= 19);
          this.age_group.between_20_and_23 = this.ages_of_beneficiaries_selected.filter(age => age >= 20 && age <= 23);
          this.age_group.more_than_24 = this.ages_of_beneficiaries_selected.filter(age => age >= 24);

          this.gender.male = this.total_beneficiaries_with_take_selected.filter(beneficiary => beneficiary.gender == "masculino");
          this.gender.female = this.total_beneficiaries_with_take_selected.filter(beneficiary => beneficiary.gender == "femenino");
          this.gender.other = this.total_beneficiaries_with_take_selected.filter(beneficiary => beneficiary.gender == "otro");

          this.risk_level.low = this.risk_level_of_beneficiaries_selected.filter(risk_level => risk_level < 7);
          this.risk_level.medium = this.risk_level_of_beneficiaries_selected.filter(risk_level => risk_level >= 8 && risk_level <= 13);
          this.risk_level.high = this.risk_level_of_beneficiaries_selected.filter(risk_level => risk_level >= 14 && risk_level <= 20);
          this.risk_level.critical = this.risk_level_of_beneficiaries_selected.filter(risk_level => risk_level >= 21);
        }
      },
      showBtn(){
        if(this.take_selected){
          this.resultsBtn = true
        } else {
          this.resultsBtn = false
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
            this.yttv1_data_selected= false;
            this.yttv2_data_selected= false;
            this.resultsBtn = false;
            this.take_selected = '';
          }
          
          
        }
      },
      loadUser(){
        this.$Progress.start();
        this.loading = true;
        axios.get("api/profile").then(({ data }) => (
          this.user = data,
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
