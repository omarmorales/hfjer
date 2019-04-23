<template lang="html">
  <div class="beneficiary">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
              {{ beneficiary.folio }}
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
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
            Evaluaciones
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
                    <th scope="col">Nivel de riesgo general</th>
                    <th scope="col">Nivel de propensión a conductas violentas</th>
                    <th scope="col">Nivel de exposición a la violencia</th>
                    <th scope="col">Fecha de creación</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="ytt1_evaluation in beneficiary.ytt1_evaluations" v-show="ytt1_evaluation.beneficiary_id == beneficiary.id">
                    <th scope="row">{{ ytt1_evaluation.id }}</th>
                    <td>
                      <span class="badge badge-success" v-if="ytt1_evaluation.risk_level < 2.5">Bajo</span>
                      <span class="badge badge-warning" v-else-if="ytt1_evaluation.risk_level < 5">Medio</span>
                      <span class="badge badge-danger" v-else-if="ytt1_evaluation.risk_level < 7.5 ">Alto</span>
                      <span class="badge badge-dark" v-else>Crítico</span>
                    </td>
                    <td>
                      <span class="badge badge-success" v-if="ytt1_evaluation.propensity_level < 2.5">Bajo</span>
                      <span class="badge badge-warning" v-else-if="ytt1_evaluation.propensity_level < 5">Medio</span>
                      <span class="badge badge-danger" v-else-if="ytt1_evaluation.propensity_level < 7.5 ">Alto</span>
                      <span class="badge badge-dark" v-else>Crítico</span>
                    </td>
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
    <div class="row" v-show="beneficiary.group.evaluation == 'yttv1'">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            Borradores
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Fecha de creación</th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="draft in beneficiary.ytt1_drafts" :key="draft.id">
                    <th scope="row">{{ draft.id }}</th>
                    <td>{{ draft.created_at | myDate }}</td>
                    <td>
                      <router-link :to="{ name: 'Evaluation', params: { beneficiary } }">
                        <i class="fas fa-edit"></i>
                      </router-link>
                    </td>
                    <td>
                      <a href="#">
                        <i class="fas fa-trash text-danger"></i>
                      </a>
                    </td>
                  </tr>
                  <!-- <tr v-for="ytt1_draft in beneficiary.ytt1_drafts" v-show="ytt1_draft.beneficiary_id == beneficiary.id">
                    <th scope="row">{{ ytt1_evaluation.id }}</th>
                    <td>
                      <span class="badge badge-success" v-if="ytt1_draft.risk_level < 2.5">Bajo</span>
                      <span class="badge badge-warning" v-else-if="ytt1_draft.risk_level < 5">Medio</span>
                      <span class="badge badge-danger" v-else-if="ytt1_draft.risk_level < 7.5 ">Alto</span>
                      <span class="badge badge-dark" v-else>Crítico</span>
                    </td>
                    <td>
                      <span class="badge badge-success" v-if="ytt1_draft.propensity_level < 2.5">Bajo</span>
                      <span class="badge badge-warning" v-else-if="ytt1_draft.propensity_level < 5">Medio</span>
                      <span class="badge badge-danger" v-else-if="ytt1_draft.propensity_level < 7.5 ">Alto</span>
                      <span class="badge badge-dark" v-else>Crítico</span>
                    </td>
                    <td>
                      <span class="badge badge-success" v-if="ytt1_draft.exposure_level < 2.5">Bajo</span>
                      <span class="badge badge-warning" v-else-if="ytt1_draft.exposure_level < 5">Medio</span>
                      <span class="badge badge-danger" v-else-if="ytt1_draft.exposure_level < 7.5 ">Alto</span>
                      <span class="badge badge-dark" v-else>Crítico</span>
                    </td>
                    <td>{{ ytt1_draft.created_at | myDate }}</td>
                    <td>
                      <a href="#">
                        <i class="fas fa-eye"></i>
                      </a>
                    </td>
                  </tr> -->
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
            Evaluaciones
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
                    <th scope="col">Nivel de riesgo general</th>
                    <th scope="col">Fecha de creación</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="ytt2_evaluation in beneficiary.ytt2_evaluations" v-show="ytt2_evaluation.beneficiary_id == beneficiary.id">
                    <th scope="row">{{ ytt2_evaluation.id }}</th>
                    <td>
                      <span class="badge badge-success">{{ ytt2_evaluation.risk_level }}</span>
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
        <beneficiaryprogress-card />
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

  },
  created(){
    axios.get('/api/beneficiary/'+this.$route.params.id).then(({data}) => (this.beneficiary = data));
  }
}
</script>

<style lang="css" scoped>
</style>
