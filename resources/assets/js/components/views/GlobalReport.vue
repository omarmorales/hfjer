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
          <h3 class="font-weight-bold text-uppercase text-center">
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
          :loaded="loaded"
          :chartData="chartData"
          :chartOptions="chartOptions"
          :chartDataRL="chartDataRL"
          :chartOptionsRL="chartOptionsRL"
          :chartDataRLG="chartDataRLG"
          :chartOptionsRLG="chartOptionsRLG"
          :chartDataELG="chartDataELG"
          :chartOptionsELG="chartOptionsELG"
          :chartDataPLG="chartDataPLG"
          :chartOptionsPLG="chartOptionsPLG"
          :chartDataGR="chartDataGR"
          :chartOptionsGR="chartOptionsGR"
          :group_selected="group_selected"
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
        exposure_level_of_beneficiaries_selected: '',
        age_group: {
            less_than_11: '',
            between_12_and_15: '',
            between_16_and_19: '',
            between_20_and_23: '',
            more_than_24: ''
        },
        risk_level_male: '',
        risk_level_female: '',
        risk_level_other: '',
        exposure_level_male: '',
        exposure_level_female: '',
        exposure_level_other: '',
        propensity_level_male: '',
        propensity_level_female: '',
        propensity_level_other: '',
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
        loaded: false,
        chartData: {
          labels: ['<11', '12-15', '16-19', '20-23', '>=24'],
          datasets: [
              {
                label: 'Población',
                fill: false,
                backgroundColor: ['#002F6C','#00A9B7','#0E9E82','#FF6767','#BA0C2F'],
                data: [1,1,1,1,1],
              }
          ]
        },
        chartOptions: {
          legend: {
              position: 'bottom'
          }
        },
        chartDataGR: {
          labels: ['Nivel de riesgo','Nivel de exposición','Nivel de propensión'],
          datasets: [
              {
                label: 'Bajo',
                fill: false,
                backgroundColor: '#002F6C',
                data: [0,0,0],
              },
              {
                label: 'Medio',
                fill: false,
                backgroundColor: '#00A9B7',
                data: [0,0,0],
              },
              {
                label: 'Alto',
                fill: false,
                backgroundColor: '#FF6767',
                data: [0,0,0],
              },
              {
                label: 'Crítico',
                fill: false,
                backgroundColor: '#BA0C2F',
                data: [0,0,0],
              },
          ]
        },
        chartOptionsGR: {
          legend: {
              position: 'bottom'
          },
          scales: {	
            yAxes: [{	
              ticks: {	
                beginAtZero: true,	
                callback: function (value) { if (Number.isInteger(value)) { return value; } },	
              }	
            }]	
          },	
        },
        chartDataRL: {
          labels: ['Nivel de riesgo'],
          datasets: [
              {
                label: 'Bajo',
                fill: false,
                backgroundColor: '#002F6C',
                data: [0],
              },
              {
                label: 'Medio',
                fill: false,
                backgroundColor: '#00A9B7',
                data: [0],
              },
              {
                label: 'Alto',
                fill: false,
                backgroundColor: '#FF6767',
                data: [0],
              },
              {
                label: 'Crítico',
                fill: false,
                backgroundColor: '#BA0C2F',
                data: [0],
              },
          ]
        },
        chartOptionsRL: {
          legend: {
              position: 'bottom'
          },
          scales: {	
            yAxes: [{	
              ticks: {	
                beginAtZero: true,	
                callback: function (value) { if (Number.isInteger(value)) { return value; } },	
              }	
            }]	
          },	
        },
        chartDataRLG: {
          labels: ['Bajo','Medio','Alto', 'Crítico'],
          datasets: [
              {
                label: 'Mujeres',
                fill: false,
                backgroundColor: '#002F6C',
                data: [0,0,0,0],
              },
              {
                label: 'Hombres',
                fill: false,
                backgroundColor: '#00A9B7',
                data: [0,0,0,0],
              },
              {
                label: 'Otro',
                fill: false,
                backgroundColor: '#FF6767',
                data: [0,0,0,0],
              },
          ]
        },
        chartOptionsRLG: {
          legend: {
              position: 'bottom'
          },
          scales: {	
            yAxes: [{	
              ticks: {	
                beginAtZero: true,	
                callback: function (value) { if (Number.isInteger(value)) { return value; } },	
              }	
            }]	
          },	
        },
        chartDataELG: {
          labels: ['Bajo','Medio','Alto', 'Crítico'],
          datasets: [
              {
                label: 'Mujeres',
                fill: false,
                backgroundColor: '#002F6C',
                data: [0,0,0,0],
              },
              {
                label: 'Hombres',
                fill: false,
                backgroundColor: '#00A9B7',
                data: [0,0,0,0],
              },
              {
                label: 'Otro',
                fill: false,
                backgroundColor: '#FF6767',
                data: [0,0,0,0],
              },
          ]
        },
        chartOptionsELG: {
          legend: {
              position: 'bottom'
          },
          scales: {	
            yAxes: [{	
              ticks: {	
                beginAtZero: true,	
                callback: function (value) { if (Number.isInteger(value)) { return value; } },	
              }	
            }]	
          },	
        },
        chartDataPLG: {
          labels: ['Bajo','Medio','Alto', 'Crítico'],
          datasets: [
              {
                label: 'Mujeres',
                fill: false,
                backgroundColor: '#002F6C',
                data: [0,0,0,0],
              },
              {
                label: 'Hombres',
                fill: false,
                backgroundColor: '#00A9B7',
                data: [0,0,0,0],
              },
              {
                label: 'Otro',
                fill: false,
                backgroundColor: '#FF6767',
                data: [0,0,0,0],
              },
          ]
        },
        chartOptionsPLG: {
          legend: {
              position: 'bottom'
          },
          scales: {	
            yAxes: [{	
              ticks: {	
                beginAtZero: true,	
                callback: function (value) { if (Number.isInteger(value)) { return value; } },	
              }	
            }]	
          },	
        },
      }
    },
    methods:{
      showData(){
        this.loaded = true;
        if (this.group_selected.evaluation == "yttv2"){
          this.yttv1_data_selected = false;
          this.yttv2_data_selected = true;
        } else if (this.group_selected.evaluation == "yttv1"){
          this.yttv1_data_selected = true;
          this.yttv2_data_selected = false;
        }
      },
      showBtn(){
        this.yttv1_data_selected= false;
        this.yttv2_data_selected= false;
        this.resultsBtn = false;
        this.loaded = false;
        if(this.take_selected){
          this.resultsBtn = true

          if (this.group_selected.evaluation == "yttv2"){
            this.total_beneficiaries_with_take_selected = this.beneficiaries.filter(beneficiary => beneficiary.ytt2_evaluations.length >= this.take_selected);
            this.ages_of_beneficiaries_selected = this.total_beneficiaries_with_take_selected.map(beneficiary => beneficiary.ytt2_evaluations[this.take_selected-1].age);
            this.risk_level_of_beneficiaries_selected = this.total_beneficiaries_with_take_selected.map(beneficiary => beneficiary.ytt2_evaluations[this.take_selected-1].risk_level);
            
            this.gender.male = this.total_beneficiaries_with_take_selected.filter(beneficiary => beneficiary.gender == "masculino");
            this.gender.female = this.total_beneficiaries_with_take_selected.filter(beneficiary => beneficiary.gender == "femenino");
            this.gender.other = this.total_beneficiaries_with_take_selected.filter(beneficiary => beneficiary.gender == "otro");

            this.chartData.datasets[0].data[0] = this.ages_of_beneficiaries_selected.filter(age => age < 11).length;
            this.chartData.datasets[0].data[1] = this.ages_of_beneficiaries_selected.filter(age => age >= 12 && age <= 15).length;
            this.chartData.datasets[0].data[2] = this.ages_of_beneficiaries_selected.filter(age => age >= 16 && age <= 19).length;
            this.chartData.datasets[0].data[3] = this.ages_of_beneficiaries_selected.filter(age => age >= 20 && age <= 23).length;
            this.chartData.datasets[0].data[4] = this.ages_of_beneficiaries_selected.filter(age => age >= 24).length;

            this.chartDataRL.datasets[0].data[0] = this.risk_level_of_beneficiaries_selected.filter(risk_level => risk_level < 7).length;
            this.chartDataRL.datasets[1].data[0] = this.risk_level_of_beneficiaries_selected.filter(risk_level => risk_level >= 8 && risk_level <= 13).length;
            this.chartDataRL.datasets[2].data[0] = this.risk_level_of_beneficiaries_selected.filter(risk_level => risk_level >= 14 && risk_level <= 20).length;
            this.chartDataRL.datasets[3].data[0] = this.risk_level_of_beneficiaries_selected.filter(risk_level => risk_level >= 21).length;
          } else if (this.group_selected.evaluation == "yttv1") {
            this.total_beneficiaries_with_take_selected = this.beneficiaries.filter(beneficiary => beneficiary.ytt1_evaluations.length >= this.take_selected);
            this.ages_of_beneficiaries_selected = this.total_beneficiaries_with_take_selected.map(beneficiary => beneficiary.ytt1_evaluations[this.take_selected-1].age);
            this.risk_level_of_beneficiaries_selected = this.total_beneficiaries_with_take_selected.map(beneficiary => beneficiary.ytt1_evaluations[this.take_selected-1].risk_level);
            this.exposure_level_of_beneficiaries_selected = this.total_beneficiaries_with_take_selected.map(beneficiary => beneficiary.ytt1_evaluations[this.take_selected-1].exposure_level);
            this.propensity_level_of_beneficiaries_selected = this.total_beneficiaries_with_take_selected.map(beneficiary => beneficiary.ytt1_evaluations[this.take_selected-1].propensity_level);

            this.gender.male = this.total_beneficiaries_with_take_selected.filter(beneficiary => beneficiary.gender == "masculino");
            this.gender.female = this.total_beneficiaries_with_take_selected.filter(beneficiary => beneficiary.gender == "femenino");
            this.gender.other = this.total_beneficiaries_with_take_selected.filter(beneficiary => beneficiary.gender == "otro");

            this.risk_level_male = this.gender.male.map(beneficiary => beneficiary.ytt1_evaluations[this.take_selected-1].risk_level);
            this.risk_level_female = this.gender.female.map(beneficiary => beneficiary.ytt1_evaluations[this.take_selected-1].risk_level);
            this.risk_level_other = this.gender.other.map(beneficiary => beneficiary.ytt1_evaluations[this.take_selected-1].risk_level);

            this.exposure_level_male = this.gender.male.map(beneficiary => beneficiary.ytt1_evaluations[this.take_selected-1].exposure_level);
            this.exposure_level_female = this.gender.female.map(beneficiary => beneficiary.ytt1_evaluations[this.take_selected-1].exposure_level);
            this.exposure_level_other = this.gender.other.map(beneficiary => beneficiary.ytt1_evaluations[this.take_selected-1].exposure_level);

            this.propensity_level_male = this.gender.male.map(beneficiary => beneficiary.ytt1_evaluations[this.take_selected-1].propensity_level);
            this.propensity_level_female = this.gender.female.map(beneficiary => beneficiary.ytt1_evaluations[this.take_selected-1].propensity_level);
            this.propensity_level_other = this.gender.other.map(beneficiary => beneficiary.ytt1_evaluations[this.take_selected-1].propensity_level);

            this.chartDataRLG.datasets[0].data[0] = this.risk_level_female.filter(risk_level => risk_level < 2.5).length;
            this.chartDataRLG.datasets[0].data[1] = this.risk_level_female.filter(risk_level => risk_level >= 2.5 && risk_level <= 5.0).length;
            this.chartDataRLG.datasets[0].data[2] = this.risk_level_female.filter(risk_level => risk_level >= 5.1 && risk_level <= 7.5).length;
            this.chartDataRLG.datasets[0].data[3] = this.risk_level_female.filter(risk_level => risk_level >= 7.5).length;

            this.chartDataRLG.datasets[1].data[0] = this.risk_level_male.filter(risk_level => risk_level < 2.5).length;
            this.chartDataRLG.datasets[1].data[1] = this.risk_level_male.filter(risk_level => risk_level >= 2.5 && risk_level <= 5.0).length;
            this.chartDataRLG.datasets[1].data[2] = this.risk_level_male.filter(risk_level => risk_level >= 5.1 && risk_level <= 7.5).length;
            this.chartDataRLG.datasets[1].data[3] = this.risk_level_male.filter(risk_level => risk_level >= 7.5).length;

            this.chartDataRLG.datasets[2].data[0] = this.risk_level_other.filter(risk_level => risk_level < 2.5).length;
            this.chartDataRLG.datasets[2].data[1] = this.risk_level_other.filter(risk_level => risk_level >= 2.5 && risk_level <= 5.0).length;
            this.chartDataRLG.datasets[2].data[2] = this.risk_level_other.filter(risk_level => risk_level >= 5.1 && risk_level <= 7.5).length;
            this.chartDataRLG.datasets[2].data[3] = this.risk_level_other.filter(risk_level => risk_level >= 7.5).length;

            this.chartDataELG.datasets[0].data[0] = this.exposure_level_female.filter(risk_level => risk_level < 2.5).length;
            this.chartDataELG.datasets[0].data[1] = this.exposure_level_female.filter(risk_level => risk_level >= 2.5 && risk_level <= 5.0).length;
            this.chartDataELG.datasets[0].data[2] = this.exposure_level_female.filter(risk_level => risk_level >= 5.1 && risk_level <= 7.5).length;
            this.chartDataELG.datasets[0].data[3] = this.exposure_level_female.filter(risk_level => risk_level >= 7.5).length;

            this.chartDataELG.datasets[1].data[0] = this.exposure_level_male.filter(risk_level => risk_level < 2.5).length;
            this.chartDataELG.datasets[1].data[1] = this.exposure_level_male.filter(risk_level => risk_level >= 2.5 && risk_level <= 5.0).length;
            this.chartDataELG.datasets[1].data[2] = this.exposure_level_male.filter(risk_level => risk_level >= 5.1 && risk_level <= 7.5).length;
            this.chartDataELG.datasets[1].data[3] = this.exposure_level_male.filter(risk_level => risk_level >= 7.5).length;

            this.chartDataELG.datasets[2].data[0] = this.exposure_level_other.filter(risk_level => risk_level < 2.5).length;
            this.chartDataELG.datasets[2].data[1] = this.exposure_level_other.filter(risk_level => risk_level >= 2.5 && risk_level <= 5.0).length;
            this.chartDataELG.datasets[2].data[2] = this.exposure_level_other.filter(risk_level => risk_level >= 5.1 && risk_level <= 7.5).length;
            this.chartDataELG.datasets[2].data[3] = this.exposure_level_other.filter(risk_level => risk_level >= 7.5).length;

            this.chartDataPLG.datasets[0].data[0] = this.propensity_level_female.filter(risk_level => risk_level < 2.5).length;
            this.chartDataPLG.datasets[0].data[1] = this.propensity_level_female.filter(risk_level => risk_level >= 2.5 && risk_level <= 5.0).length;
            this.chartDataPLG.datasets[0].data[2] = this.propensity_level_female.filter(risk_level => risk_level >= 5.1 && risk_level <= 7.5).length;
            this.chartDataPLG.datasets[0].data[3] = this.propensity_level_female.filter(risk_level => risk_level >= 7.5).length;

            this.chartDataPLG.datasets[1].data[0] = this.propensity_level_male.filter(risk_level => risk_level < 2.5).length;
            this.chartDataPLG.datasets[1].data[1] = this.propensity_level_male.filter(risk_level => risk_level >= 2.5 && risk_level <= 5.0).length;
            this.chartDataPLG.datasets[1].data[2] = this.propensity_level_male.filter(risk_level => risk_level >= 5.1 && risk_level <= 7.5).length;
            this.chartDataPLG.datasets[1].data[3] = this.propensity_level_male.filter(risk_level => risk_level >= 7.5).length;

            this.chartDataPLG.datasets[2].data[0] = this.propensity_level_other.filter(risk_level => risk_level < 2.5).length;
            this.chartDataPLG.datasets[2].data[1] = this.propensity_level_other.filter(risk_level => risk_level >= 2.5 && risk_level <= 5.0).length;
            this.chartDataPLG.datasets[2].data[2] = this.propensity_level_other.filter(risk_level => risk_level >= 5.1 && risk_level <= 7.5).length;
            this.chartDataPLG.datasets[2].data[3] = this.propensity_level_other.filter(risk_level => risk_level >= 7.5).length;

            this.chartData.datasets[0].data[0] = this.ages_of_beneficiaries_selected.filter(age => age < 11).length;
            this.chartData.datasets[0].data[1] = this.ages_of_beneficiaries_selected.filter(age => age >= 12 && age <= 15).length;
            this.chartData.datasets[0].data[2] = this.ages_of_beneficiaries_selected.filter(age => age >= 16 && age <= 19).length;
            this.chartData.datasets[0].data[3] = this.ages_of_beneficiaries_selected.filter(age => age >= 20 && age <= 23).length;
            this.chartData.datasets[0].data[4] = this.ages_of_beneficiaries_selected.filter(age => age >= 24).length;

            this.chartDataGR.datasets[0].data[0] = this.risk_level_of_beneficiaries_selected.filter(risk_level => risk_level < 2.5).length;
            this.chartDataGR.datasets[1].data[0] = this.risk_level_of_beneficiaries_selected.filter(risk_level => risk_level >= 2.5 && risk_level <= 5.0).length;
            this.chartDataGR.datasets[2].data[0] = this.risk_level_of_beneficiaries_selected.filter(risk_level => risk_level >= 5.1 && risk_level <= 7.5).length;
            this.chartDataGR.datasets[3].data[0] = this.risk_level_of_beneficiaries_selected.filter(risk_level => risk_level > 7.5).length;
            
            this.chartDataGR.datasets[0].data[1] = this.exposure_level_of_beneficiaries_selected.filter(exposure_level => exposure_level < 2.5).length;
            this.chartDataGR.datasets[1].data[1] = this.exposure_level_of_beneficiaries_selected.filter(exposure_level => exposure_level >= 2.5 && exposure_level <= 5).length;
            this.chartDataGR.datasets[2].data[1] = this.exposure_level_of_beneficiaries_selected.filter(exposure_level => exposure_level >= 5.1 && exposure_level <= 7.5).length;
            this.chartDataGR.datasets[3].data[1] = this.exposure_level_of_beneficiaries_selected.filter(exposure_level => exposure_level > 7.5).length;
            
            this.chartDataGR.datasets[0].data[2] = this.propensity_level_of_beneficiaries_selected.filter(propensity_level => propensity_level < 2.5).length;
            this.chartDataGR.datasets[1].data[2] = this.propensity_level_of_beneficiaries_selected.filter(propensity_level => propensity_level >= 2.5 && propensity_level <= 5).length;
            this.chartDataGR.datasets[2].data[2] = this.propensity_level_of_beneficiaries_selected.filter(propensity_level => propensity_level >= 5.1 && propensity_level <= 7.5).length;
            this.chartDataGR.datasets[3].data[2] = this.propensity_level_of_beneficiaries_selected.filter(propensity_level => propensity_level > 7.5).length;
          }
        } else {
          this.resultsBtn = false
          this.loaded = false
        }
      },
      getBeneficiaries(){
        if(this.group_selected) {
          this.max_takes = '';
          this.beneficiaries= '';
          this.beneficiaries_takes= [];
          this.yttv1_data_selected= false;
          this.yttv2_data_selected= false;
          this.resultsBtn = false;
          this.loaded = false;
          this.take_selected = '';

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
            this.loaded = false;
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
