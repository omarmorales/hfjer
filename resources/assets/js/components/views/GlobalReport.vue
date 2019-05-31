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
              <option v-for="(take, index) in max_takes" :value="take">{{ take }}</option>
            </select>
          </div>
          <div class="form-group" v-show="resultsBtn">
            <button class="btn btn-primary" @click="showData">Obtener datos</button>
          </div>
        </div>
      </div>
      <div class="row">
        <div id="yttv1" class="col-md-12" v-if="yttv1_data_selected == true">
          hola
        </div>
        <div id="yttv2" class="col-md-12" v-if="yttv2_data_selected == true">
          <div class="row">
            <div class="col-md-3">
              <div class="card">
                <div class="card-body text-center">
                  <p class="font-weight-bolder h2">{{ total_beneficiaries_with_take_selected.length }}</p>
                  <p>Muestra total</p>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card">
                <div class="card-body text-center">
                  <p class="font-weight-bolder h2">{{ total_beneficiaries_with_take_selected_female.length }}</p>
                  <p>Mujer(es)</p>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card">
                <div class="card-body text-center">
                  <p class="font-weight-bolder h2">{{ total_beneficiaries_with_take_selected_male.length }}</p>
                  <p>Hombre(s)</p>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card">
                <div class="card-body text-center">
                  <p class="font-weight-bolder h2">{{ total_beneficiaries_with_take_selected_other.length }}</p>
                  <p>Otro(s)</p>
                </div>
              </div>
            </div>
          </div>
        </div>
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
        total_beneficiaries_with_take_selected_male: '',
        total_beneficiaries_with_take_selected_female: '',
        total_beneficiaries_with_take_selected_other: '',
      }
    },
    methods:{
      showData(){
        if (this.group_selected.evaluation == "yttv2"){
          this.yttv1_data_selected = false;
          this.yttv2_data_selected = true;
          this.total_beneficiaries_with_take_selected = this.beneficiaries.filter(beneficiary => beneficiary.ytt2_evaluations.length >= this.take_selected);
          this.total_beneficiaries_with_take_selected_male = this.total_beneficiaries_with_take_selected.filter(beneficiary => beneficiary.gender == "masculino");
          this.total_beneficiaries_with_take_selected_female = this.total_beneficiaries_with_take_selected.filter(beneficiary => beneficiary.gender == "femenino");
          this.total_beneficiaries_with_take_selected_other = this.total_beneficiaries_with_take_selected.filter(beneficiary => beneficiary.gender == "otro");
        } else if (this.group_selected.evaluation == "yttv1"){
          this.yttv1_data_selected = true;
          this.yttv2_data_selected = false;
          this.total_beneficiaries_with_take_selected = this.beneficiaries.filter(beneficiary => beneficiary.ytt1_evaluations.length >= this.take_selected);
          this.total_beneficiaries_with_take_selected_male = this.total_beneficiaries_with_take_selected.filter(beneficiary => beneficiary.gender == "masculino");
          this.total_beneficiaries_with_take_selected_female = this.total_beneficiaries_with_take_selected.filter(beneficiary => beneficiary.gender == "femenino");
          this.total_beneficiaries_with_take_selected_other = this.total_beneficiaries_with_take_selected.filter(beneficiary => beneficiary.gender == "otro");
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
