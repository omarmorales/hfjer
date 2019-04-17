<template lang="html">
  <div class="container">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <router-link to="/overview">Inicio</router-link>
              </li>
              <li class="breadcrumb-item active">
                Reporte global
              </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="row">
      <div class="col-md-12">
        <h1 class="m-0 text-dark text-center mt-4">
          Reporte global
        </h1>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="">Grupo</label>
          <select class="form-control" id="group" v-model="group">
            <option v-for="group in groups" :key="group.id" v-show="group.user_id == user.id" :value="group.id">{{ group.name }}</option>
          </select>
        </div>
        <div class="form-group">
          <label for="">Número de toma</label>
          <select class="form-control" id="group" v-model="take">
            <option value="1">Toma 1</option>
            <option value="2">Toma 2</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row" v-show="group == 7 && take == 1">
      <div class="col-md-12">
        <p class="h5">Descripción de la población</p>
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
                        <th>Nivel de riesgo</th>
                        <th>Resultado</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Alto</td>
                        <td>1</td>
                      </tr>
                      <tr>
                        <td>Crítico</td>
                        <td>1</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-md-6">
                <chart-component :height="150" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row" v-show="group == 7 && take == 2">
      <div class="col-md-12">
        <p class="h5">Descripción de la población</p>
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
                        <th>Nivel de riesgo</th>
                        <th>Resultado</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Bajo</td>
                        <td>1</td>
                      </tr>
                      <tr>
                        <td>Alto</td>
                        <td>1</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-md-6">
                <chart-component4 :height="150" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <button v-if="group && take" type="button" class="btn btn-primary mb-3" name="button" @click.prevent="printme">
      Imprimir
      <i class="fas fa-print"></i>
    </button>
  </div>
</template>

<script>
export default {
  data(){
    return {
      group: '',
      take: '',
      user:[],
      groups: {},
    }
  },
  methods: {
    printme() {
        window.print();
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
