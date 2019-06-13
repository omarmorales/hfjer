<template>
  <div class="container">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <router-link to="/home">Grupos</router-link>
              </li>
              <li class="breadcrumb-item">
                <router-link :to="`/group/${$route.params.group}`">{{ $route.params.group }}</router-link>
              </li>
              <li class="breadcrumb-item active">{{ beneficiary.folio }}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <div class="row">
      <div class="col-md-12">
        <h2 class="text-center font-weight-bold text-uppercase">
          {{ beneficiary.folio }}
        </h2>
      </div>
      <div class="col-md-12">
        <a class="btn btn-success pointer float-right mb-3 text-white" @click="sendToEvaluation(beneficiary)">
          Nueva toma <i class="fas fa-file-invoice"></i>
        </a>
      </div>
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <p class="card-title">Información general</p>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Folio</label>
                  <p>
                    {{ beneficiary.folio  }}
                  </p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Nombre completo</label>
                  <p>
                    {{ beneficiary.name  }} {{ beneficiary.lastname_one  }} {{ beneficiary.lastname_two  }}
                  </p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Género</label>
                  <p>
                    {{ beneficiary.gender  }}
                  </p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Fecha de nacimiento</label>
                  <p>
                    {{ beneficiary.birthdate | myDate }}
                  </p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Grupo</label>
                  <p>
                    {{ group.name  }}
                  </p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Herramienta</label>
                  <p>
                    {{ group.evaluation  }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>



    <div class="row" v-show="group.evaluation == 'yttv1'">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            Tomas
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>
                      <span class="">#</span> 
                    </th>
                    <th class="">
                      <span class="">Puntuación nivel de riesgo general</span>
                    </th>
                    <th class="">Nivel de riesgo general</th>
                    <th>Puntuación nivel de propensión a conductas violentas</th>
                    <th class="">
                      <span class="">Nivel de propensión a conductas violentas</span>
                    </th>
                    <th>Puntuación nivel de exposición a la violencia</th>
                    <th class="">Nivel de exposición a la violencia</th>
                    <th class="">Fecha de creación</th>
                    <th>Ver resultados</th>
                    <th>Eliminar toma</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(ytt1_evaluation, index) in beneficiary.ytt1_evaluations" :key="index" v-show="ytt1_evaluation.beneficiary_id == beneficiary.id">
                    <th scope="row">{{ index + 1 }}</th>
                    <td class="text-center">{{ ytt1_evaluation.risk_level }}</td>
                    <td class="text-center">
                      <span class="badge badge-success" v-if="ytt1_evaluation.risk_level < 2.5">Bajo</span>
                      <span class="badge badge-warning" v-else-if="ytt1_evaluation.risk_level < 5">Medio</span>
                      <span class="badge badge-danger" v-else-if="ytt1_evaluation.risk_level < 7.5 ">Alto</span>
                      <span class="badge badge-dark" v-else>Crítico</span>
                    </td>
                    <td class="text-center">{{ ytt1_evaluation.propensity_level }}</td>
                    <td class="text-center">
                      <span class="badge badge-success" v-if="ytt1_evaluation.propensity_level < 2.5">Bajo</span>
                      <span class="badge badge-warning" v-else-if="ytt1_evaluation.propensity_level < 5">Medio</span>
                      <span class="badge badge-danger" v-else-if="ytt1_evaluation.propensity_level < 7.5 ">Alto</span>
                      <span class="badge badge-dark" v-else>Crítico</span>
                    </td>
                    <td class="text-center">{{ ytt1_evaluation.exposure_level }}</td>
                    <td>
                      <span class="badge badge-success" v-if="ytt1_evaluation.exposure_level < 2.5">Bajo</span>
                      <span class="badge badge-warning" v-else-if="ytt1_evaluation.exposure_level < 5">Medio</span>
                      <span class="badge badge-danger" v-else-if="ytt1_evaluation.exposure_level < 7.5 ">Alto</span>
                      <span class="badge badge-dark" v-else>Crítico</span>
                    </td>
                    <td>{{ ytt1_evaluation.created_at | myDate }}</td>
                    <td>
                      <router-link class="text-center" :to="`/group/${$route.params.group}/${beneficiary.folio}/evaluation/${ytt1_evaluation.id}`">
                        <i class="fas fa-eye"></i>
                      </router-link>
                    </td>
                    <td>
                      <a class="text-danger text-center pointer" @click="deleteEvaluation(ytt1_evaluation.id)">
                        <i class="fas fa-trash"></i>
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row" v-show="group.evaluation == 'yttv2'">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            Tomas
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>
                      <span class="">#</span> 
                    </th>
                    <th class="">
                      <span class="">Puntuación nivel de riesgo general</span>
                    </th>
                    <th class="">Nivel de riesgo general</th>
                    <th class="">Fecha de creación</th>
                    <th>Ver resultados</th>
                    <th>Eliminar toma</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(ytt2_evaluation, index) in beneficiary.ytt2_evaluations" :key="index" v-show="ytt2_evaluation.beneficiary_id == beneficiary.id">
                    <th scope="row">{{ index + 1 }}</th>
                    <td class="text-center">{{ ytt2_evaluation.risk_level }}</td>
                    <td class="text-center">
                      <span class="badge badge-success" v-if="ytt2_evaluation.risk_level < 7">Bajo</span>
                      <span class="badge badge-warning" v-else-if="ytt2_evaluation.risk_level < 13">Medio</span>
                      <span class="badge badge-danger" v-else-if="ytt2_evaluation.risk_level < 20 ">Alto</span>
                      <span class="badge badge-dark" v-else>Crítico</span>
                    </td>
                    <td>{{ ytt2_evaluation.created_at | myDate }}</td>
                    <td>
                      <router-link class="text-center" :to="`/group/${$route.params.group}/${beneficiary.folio}/evaluation/${ytt2_evaluation.id}`">
                        <i class="fas fa-eye"></i>
                      </router-link>
                    </td>
                    <td>
                      <a class="text-danger text-center pointer" @click="deleteEvaluation(ytt2_evaluation.id)">
                        <i class="fas fa-trash"></i>
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <beneficiaryprogress-card :evaluations="evaluations" />
      </div>
    </div>

  </div>
</template>

<script>
  export default {
    data() {
        return {
          beneficiary: {},
          group: {},
          evaluations: [],
        }
    },
    methods: {
      deleteEvaluation(id){
        if(this.group.evaluation == "yttv1"){
          swal({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
          }).then((result) => {
            if (result.value) {
              axios.delete(`/api/ytt1evaluation/${id}`, { data: { id: id } })
              .then(()=>{
                swal(
                  '¡Eliminada!',
                  'Toma eliminada.',
                  'success'
                )
                Fire.$emit('AfterCreate');
              }).catch(()=> {
                swal("Error", "Algo salió mal.", "warning");
              });
            }
          })
        } else{
          swal({
            title: 'Estás seguro?',
            text: "¡No podrás revertir esto!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
          }).then((result) => {
            if (result.value) {
              axios.delete(`/api/ytt2evaluation/${id}`, { data: { id: id } })
              .then(()=>{
                swal(
                  '¡Eliminada!',
                  'Toma eliminada.',
                  'success'
                )
                Fire.$emit('AfterCreate');
              }).catch(()=> {
                swal("Error", "Algo salió mal.", "warning");
              });
            }
          })
        }
      },
      sendToEvaluation(beneficiary) {
        let today = new Date();
        let birthdate = beneficiary.birthdate;
        let date_array = birthdate.split('-');
        let birthDate_calc = new Date(date_array[0],date_array[1],date_array[2]);
        let b_age = today.getFullYear() - birthDate_calc.getFullYear();
        let m = today.getMonth() - birthDate_calc.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate_calc.getDate())) {
            b_age--;
        }


        if(beneficiary.ytt1_draft || beneficiary.ytt2_draft){
            swal({
            title: 'Tienes un borrador',
            text: "¿Deseas continuar con los datos del borrador?",
            type: 'info',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí',
            cancelButtonText: 'No',
          }).then((result) => {
            
            if (result.value) {
              swal(
                'Continuar evaluación',
                '',
                'info'
              )
              this.$router.push({name: 'Evaluation', params: {group:this.$route.params.group,user:beneficiary.folio,age:b_age}});
            } else if (result.dismiss === 'cancel') {
              if(beneficiary.ytt1_draft){
                axios.delete(`/api/ytt1draft/${beneficiary.ytt1_draft.id}`, {data: { id: beneficiary.ytt1_draft.id}}).then(()=>{
                  swal(
                    'Borrador eliminado!',
                    '',
                    'success'
                  )
                }).catch(()=> {
                  swal("Error", "Algo salió mal.", "warning");
                });
              } else if (beneficiary.ytt2_draft) {
                axios.delete(`/api/ytt2draft/${beneficiary.ytt2_draft.id}`, {data: { id: beneficiary.ytt2_draft.id}}).then(()=>{
                  swal(
                    'Borrador eliminado!',
                    '',
                    'success'
                  )
                }).catch(()=> {
                  swal("Error", "Algo salió mal.", "warning");
                });
              }
              this.$router.push({name: 'Evaluation', params: {group:this.$route.params.group,user:beneficiary.folio,age:b_age}});
            }
          })
        } else {
          this.$router.push({name: 'Evaluation', params: {group:this.$route.params.group,user:beneficiary.folio,age:b_age}});
        }
      }
    },
    created(){
      Fire.$on('AfterCreate',() => {
        axios.get('/api/beneficiary_by_folio/'+this.$route.params.user).then(({data}) => (
          this.beneficiary = data,
          this.group = data.group
        ))
      });
      axios.get('/api/beneficiary_by_folio/'+this.$route.params.user).then(({data}) => (
        this.beneficiary = data,
        this.group = data.group,
        this.evaluations =  (data.group.evaluation == 'yttv1') ? data.ytt1_evaluations : data.ytt2_evaluations
      ));
    }
  }
</script>

<style lang="scss" scoped>
  .table-headers {
      position: relative;
      bottom: 1em;
  }
  .table-name {
      min-width: 14rem !important;
  }
</style>
