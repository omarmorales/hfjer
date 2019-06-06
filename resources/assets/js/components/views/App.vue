<template lang="html">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Administrar Aplicación</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <div class="row">
      <div class="col-md-12">
        <h2 class="text-center font-weight-bolder text-uppercase">
          <i class="fas fa-building"></i>
          <span v-if="$gate.isAdmin()">Organizaciones</span>
          <span v-if="$gate.isAuthor()">Organización</span>
        </h2>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <a v-if="$gate.isAdmin()" href="#" @click="newModal" class="btn btn-success float-right">Agregar organización <i class="fas fa-plus"></i></a>
      </div>
    </div>
    <div class="row" v-if="$gate.isAdmin()">
      <div class="col-md-4 mt-3" v-for="organization in organizations.data" :key="organization.id">
        <div class="card text-center" style="height:100%;">
          <div class="card-body text-center">
            <a href="#" class="text-reset">
              <h3 class="display-6 font-weight-bolder">{{ organization.name }}</h3>
            </a>
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col mb-2 text-center">
                <a href="#" @click="showOrganization(organization)" class="btn btn-primary btn-sm" style="width:100%;" tabindex="-1" role="button">Ver</a>
              </div>
              <div class="col mb-2 text-center">
                <a href="#" @click="editModal(organization)" class="btn btn-secondary btn-sm" style="width:100%;" tabindex="-1" role="button">Editar</a>
              </div>
              <div class="col mb-2 text-center">
                <a href="#" @click="deleteOrganization(organization.id)" class="btn btn-danger btn-sm" style="width:100%;" tabindex="-1" role="button">Eliminar</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12 mt-4">
        <pagination :data="organizations" @pagination-change-page="getResults"></pagination>
      </div>
    </div>
    <div class="row" v-else>
      <div class="col-md-12 mt-3" v-for="organization in organizations.data" :key="organization.id" v-if="organization.id == user.organization_id">
        <div class="card">
          <div class="card-header">
            <h3 class="display-6 font-weight-bolder">{{ organization.name }}</h3>
          </div>
          <div class="card-body">
            <div>
              <p class="ml-2 lead">{{ organization.description }}</p>
              <hr>
            </div>
            <h2 class="display-5 mt-4 mb-3">
              <i class="fas fa-user-circle"></i>
              Usuarios
            </h2>
            <users :organizationSelected="organization.id" />
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="collapse col-md-12 mt-4" id="myCollapsible">
        <div class="card">
          <div class="card-header">
            <h3 class="display-6 font-weight-bolder">{{ this.form.name }}</h3>
          </div>
          <div class="card-body">
            <div>
              <p class="ml-2 lead">{{ this.form.description }}</p>
              <hr>
            </div>
            <h2 class="display-5 mt-4 mb-3">
              <i class="fas fa-user-circle"></i>
              Usuarios
            </h2>
            <users :organizationSelected="organizationSelected" />
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addNewOrg" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Agregar organización</h5>
            <h5 class="modal-title" v-show="editmode" id="addNewLabel">Editar</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editmode ? updateOrganization() : createOrganization()">
            <div class="modal-body">
              <div class="form-group">
                <input v-model="form.name" type="text" name="name"
                placeholder="Nombre de la organización"
                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                <has-error :form="form" field="name"></has-error>
              </div>

              <div class="form-group">
                <textarea v-model="form.description" name="description" id="description"
                placeholder="Descripción de la organización"
                class="form-control" :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
                <has-error :form="form" field="description"></has-error>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              <button v-show="editmode" type="submit" class="btn btn-success">Actualizar</button>
              <button v-show="!editmode" type="submit" class="btn btn-primary">Crear</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data(){
    return{
      editmode: false,
      organizations:{},
      user: [],
      organizationSelected: '',
      form: new Form({
        id: '',
        name : '',
        description: '',
      })
    }
  },
  methods: {
    loadData(){
      if(this.$gate.isAdminOrAuthor()){
        axios.get("api/organization").then(({ data }) => (this.organizations = data));
        axios.get("api/profile").then(({ data }) => (this.user = data));
      }
    },
    getResults(page = 1) {
      axios.get('api/organization?page=' + page)
      .then(response => {
        this.organizations = response.data;
      });
    },
    showOrganization(organization){
      this.form.reset();
      $('#myCollapsible').collapse('show');
      this.form.fill(organization);
      this.organizationSelected = this.form.id;
    },
    newModal(){
      $('#myCollapsible').collapse('hide');
      this.editmode = false;
      this.form.reset();
      $('#addNewOrg').modal('show');
    },
    createOrganization(){
      this.$Progress.start();

      this.form.post('api/organization')
      .then(()=>{
        Fire.$emit('AfterCreate');
        $('#addNewOrg').modal('hide')

        toast({
          type: 'success',
          title: 'Organización creada correctamente.'
        })
        this.$Progress.finish();
      })
      .catch(()=>{

      })
    },
    editModal(organization){
      $('#myCollapsible').collapse('hide');
      this.editmode = true;
      this.form.reset();
      $('#addNewOrg').modal('show');
      this.form.fill(organization);
    },
    updateOrganization(){
      this.$Progress.start();
      // console.log('Editing data');
      this.form.put('api/organization/'+this.form.id)
      .then(() => {
        // success
        $('#addNewOrg').modal('hide');
        swal(
          'Actualizado',
          'Se ha actualizado correctamente.',
          'success'
        )
        this.$Progress.finish();
        Fire.$emit('AfterCreate');
      })
      .catch(() => {
        this.$Progress.fail();
      });
    },
    deleteOrganization(id){
      $('#myCollapsible').collapse('hide');
      swal({
        title: '¿Estás seguro?',
        text: "No podrás revertir esto",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {

        // Send request to the server
        if (result.value) {
          this.form.delete('api/organization/'+id).then(()=>{
            swal(
              'Eliminado',
              'Se ha eliminado correctamente.',
              'success'
            )
            Fire.$emit('AfterCreate');
          }).catch(()=> {
            swal("Error", "Algo salió mal.", "warning");
          });
        }
      })
    },
  },
  created(){
    this.loadData();
    Fire.$on('AfterCreate',() => {
      this.loadData();
    });
  }
}
</script>

<style lang="css">
</style>
