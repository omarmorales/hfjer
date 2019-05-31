<template lang="html">
  <div class="beneficiary">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <router-link to="/home">Grupos</router-link>
              </li>
              <li class="breadcrumb-item">
                <router-link :to="'/group/'+beneficiary.group_id">{{ beneficiary.group.name }}</router-link>
              </li>
              <li class="breadcrumb-item active">{{ beneficiary.folio }}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <div class="row">
      <div class="col-sm-12">
        <h2 class="text-center font-weight-bolder text-uppercase">
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
            Información general
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
                    {{ beneficiary.group.name  }}
                  </p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Herramienta</label>
                  <p>
                    {{ beneficiary.group.evaluation  }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row" v-show="beneficiary.group.evaluation == 'yttv1'">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            Tomas
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <col width="50">
                  <col width="50">
                  <col width="50">
                  <col width="50">
                  <col width="150">
                  <col>
                  <tr>
                    <th scope="col">#</th>
                    <th>Puntuación nivel de riesgo general</th>
                    <th scope="col">Nivel de riesgo general</th>
                    <th>Puntuación nivel de propensión a conductas violentas</th>
                    <th scope="col">Nivel de propensión a conductas violentas</th>
                    <th>Puntuación nivel de exposición a la violencia</th>
                    <th scope="col">Nivel de exposición a la violencia</th>
                    <th scope="col">Fecha de creación</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(ytt1_evaluation, index) in beneficiary.ytt1_evaluations" v-show="ytt1_evaluation.beneficiary_id == beneficiary.id">
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
                      <router-link :to="'/evaluation/'+ytt1_evaluation.id">
                        <i class="fas fa-eye"></i>
                      </router-link>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row" v-show="beneficiary.group.evaluation == 'yttv2'">
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
                    <th scope="col">#</th>
                    <th scope="col">Puntuación</th>
                    <th scope="col">Nivel de riesgo general</th>
                    <th scope="col">Fecha de creación</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(ytt2_evaluation, index) in beneficiary.ytt2_evaluations" v-show="ytt2_evaluation.beneficiary_id == beneficiary.id">
                    <th scope="row">{{ index + 1 }}</th>
                    <td>
                      {{ ytt2_evaluation.risk_level }}
                    </td>
                    <td>
                      <span class="badge badge-success" v-if="ytt2_evaluation.risk_level < 7">Bajo</span>
                      <span class="badge badge-warning" v-else-if="ytt2_evaluation.risk_level < 13">Medio</span>
                      <span class="badge badge-danger" v-else-if="ytt2_evaluation.risk_level < 20 ">Alto</span>
                      <span class="badge badge-dark" v-else>Crítico</span>
                    </td>
                    <td>{{ ytt2_evaluation.created_at | myDate }}</td>
                    <td>
                      <a href="#">
                        <i class="fas fa-eye"></i>
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
    <div class="row" v-show="beneficiary.group.evaluation == 'yttv1'">
      <div class="col-md-12">

      </div>
    </div>
  </div>
</template>

<script>
export default {
  data(){
    return{
      beneficiary: {},
    }
  },
  methods: {
    sendToEvaluation(beneficiary) {
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
            this.$router.push(`/group/${this.$route.params.id}/${beneficiary.folio}/evaluation`)
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
            this.$router.push(`/group/${this.$route.params.id}/${beneficiary.folio}/evaluation`)
          }
        })
      } else {
        this.$router.push(`/group/${this.$route.params.id}/${beneficiary.folio}/evaluation`)
      }
    }
  },
  created(){
    axios.get('/api/beneficiary_by_folio/'+this.$route.params.f).then(({data}) => (this.beneficiary = data));
  }
}
</script>

<style lang="css" scoped>
</style>
