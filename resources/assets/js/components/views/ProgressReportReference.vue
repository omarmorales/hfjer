<template lang="html">
  <div class="container">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-7">
            <h1 class="m-0 text-dark">
              Reporte de progreso de la implementación
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-5">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <router-link to="/overview">Inicio</router-link>
              </li>
              <li class="breadcrumb-item active">
                Reporte ed progreso de la implementación
              </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="row">
      <div class="col-md-12">
        <p class="h5">Progreso promedio</p>
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
                        <th>Tomas</th>
                        <th>Resultado promedio</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>toma 1</td>
                        <td>7.82</td>
                      </tr>
                      <tr>
                        <td>toma 2</td>
                        <td>3.77</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-md-6">
                <linechart-component2 :height="150" />
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
}
</script>

<style lang="css">
</style>
