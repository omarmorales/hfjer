<template lang="html">
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
                <li class="breadcrumb-item active">Inicio</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <div class="row">
        <div class="col-md-12">
          <h3 class="font-weight-bolder text-uppercase text-center">
            <i class="fas fa-users"></i>
            Administrar grupos:
          </h3>
          <a href="#" @click="newModal" class="btn btn-success float-right">Agregar grupo <i class="fas fa-plus"></i></a>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 mt-3" v-for="group in groups" :key="group.id" v-show="group.user.organization_id == user.organization_id">
          <div class="card text-center" style="height:100%;">
            <div class="card-body text-center">
              <h3 class="display-6 font-weight-bolder">
                <router-link :to="'/group/'+group.id" class="text-decoration-none text-reset">
                  {{ group.name }}
                </router-link>
              </h3>
            </div>
            <div class="card-footer">
              <div class="row">
                <div class="col mb-2 text-center">
                  <a href="#" @click="editModal(group)" class="btn btn-secondary btn-sm" style="width:100%;" tabindex="-1" role="button">
                    <i class="fas fa-pen"></i>
                  </a>
                </div>
                <div class="col mb-2 text-center">
                  <a v-if="$gate.isAdminOrAuthor()" href="#" @click="deleteGroup(group.id)" class="btn btn-danger btn-sm" style="width:100%;" tabindex="-1" role="button">
                    <i class="fas fa-trash"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="addNewGroup" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Agregar grupo</h5>
              <h5 class="modal-title" v-show="editmode" id="addNewLabel">Editar</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form @submit.prevent="editmode ? updateGroup() : createGroup()">
              <div class="modal-body">
                <div class="form-group">
                  <input v-model="form.name" type="text" name="name"
                  placeholder="Nombre de la grupo"
                  class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                  <has-error :form="form" field="name"></has-error>
                </div>

                <div class="form-group">
                  <textarea v-model="form.description" name="description" id="description"
                  placeholder="Descripción de la grupo"
                  class="form-control" :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
                  <has-error :form="form" field="description"></has-error>
                </div>

                <div class="form-group">
                  <select name="type" v-model="form.evaluation" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('evaluation') }">
                    <option value="">Selecciona la evaluacion</option>
                    <option value="yttv1">YTTv1</option>
                    <option value="yttv2">YTTv2</option>
                  </select>
                  <has-error :form="form" field="evaluation"></has-error>
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
  </div>
</template>

<script>
export default {
  data(){
    return{
      loading: false,
      editmode: false,
      groups:{},
      user: [],
      form: new Form({
        id: '',
        name : '',
        description: '',
        user_id: '',
        evaluation: '',
      })
    }
  },
  methods: {
    loadData(){
      this.loading = true;
      axios.get("api/group").then(({ data }) => 
        (
        this.loading = false,
        this.groups = data
        )
      ).catch(()=>{
        this.loading = false;
      });
      axios.get("api/profile").then(({ data }) => (this.user = data));
    },
    newModal(){
      this.editmode = false;
      this.form.reset();
      $('#addNewGroup').modal('show');
    },
    createGroup(){
      this.$Progress.start();

      this.form.user_id = this.user.id;

      this.form.post('api/group')
      .then(()=>{
        Fire.$emit('AfterCreate');
        $('#addNewGroup').modal('hide')

        toast({
          type: 'success',
          title: 'Groupo creado correctamente.'
        })
        this.$Progress.finish();
      })
      .catch(()=>{
        this.$Progress.fail();
      })
    },
    editModal(group){
      this.editmode = true;
      this.form.reset();
      $('#addNewGroup').modal('show');
      this.form.fill(group);
    },
    updateGroup(){
      this.$Progress.start();
      // console.log('Editing data');
      this.form.put('api/group/'+this.form.id)
      .then(() => {
        // success
        $('#addNewGroup').modal('hide');
        swal(
          '¡Actualizado!',
          'La información del grupo ha sido actualizada.',
          'success'
        )
        this.$Progress.finish();
        Fire.$emit('AfterCreate');
      })
      .catch(() => {
        this.$Progress.fail();
      });
    },
    deleteGroup(id){
      swal({
        title: '¿Estás seguro?',
        text: "¡No prodrás revertir esta acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar grupo',
        cancelButtonText: 'Cancelar',
      }).then((result) => {

        // Send request to the server
        if (result.value) {
          this.form.delete('api/group/'+id).then(()=>{
            swal(
              'Eliminado',
              'El grupo ha sido eliminado correctamente.',
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
