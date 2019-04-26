<template lang="html">
  <div class="container">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">
              Reporte comparativo
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <router-link to="/overview">Inicio</router-link>
              </li>
              <li class="breadcrumb-item active">
                Reporte comparativo
              </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="">Grupo</label>
          <select class="form-control" id="group" v-model="group">
            <option v-for="group in groups" :key="group.id" v-show="group.user_id == user.id" :value="group.id">{{ group.name }}</option>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <label for="">Toma base</label>
        <input v-model="take_one" type="number" class="form-control">
      </div>
      <div class="col-md-6">
        <label for="">Toma comparativa</label>
        <input v-model="take_two" type="number" class="form-control">
      </div>
      <div class="form-group col-md-12 mt-3" v-show="group">
        <button class="btn btn-primary" @click="generateReport">Generar reporte</button>
      </div>
    </div>
    <div class="row mt-3" v-show="report">
      <div class="col-md-12">
        <p class="h5">Personas comparadas: 2</p>
      </div>
      <div class="col-md-12">
        <p class="h5">Población desagregada por género</p>
      </div>
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Género</th>
                        <th>Cantidad</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Masculino</td>
                        <td>1</td>
                      </tr>
                      <tr>
                        <td>Femenino</td>
                        <td>1</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-md-6">
                <piechart-component :height="150" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <p class="h5">Población desagregada por grupo etario</p>
      </div>
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Grupo etario</th>
                        <th>Cantidad</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>>24</td>
                        <td>2</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-md-6">
                <piechart-component2 :height="150" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <p class="h5">Resultados globales</p>
      </div>
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Nivel de riesgo</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th>Personas que bajaron una categoría</th>
                        <td>1</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-md-6">
                <piechart-component3 :height="150" />
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-12">
        <p class="h5">Resultados por género</p>
      </div>
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Hombres</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th>Personas que bajaron una categoría</th>
                        <td>1</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-md-6">
                <chart-component2 :height="150" />
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-12">
        <p class="h5">Resultados por grupo etario</p>
      </div>
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Grupo etario</th>
                        <th>Personas que bajaron 1 categoría</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th>{{ ">24" }}</th>
                        <td>1</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-md-6">
                <chart-component3 :height="150" />
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
    return {
      report: false,
      group: '',
      take_one: '',
      take_two: '',
      user:[],
      groups: {},
    }
  },
  methods: {
    generateReport() {
      this.report = true;
    }
  },
  created(){
    axios.get('/api/group/').then(({data}) => (this.groups = data));
    axios.get("api/profile").then(({ data }) => (this.user = data));
  }
}
</script>

<style lang="css">
</style>
