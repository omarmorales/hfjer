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
                <li class="breadcrumb-item">
                  <router-link to="/home">Grupos</router-link>
                </li>
                <li class="breadcrumb-item active">{{ group.slug }}</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <div class="row">
        <div class="col-md-12">
          <h2 class="text-center font-weight-bolder text-uppercase">
            {{ group.name }}
          </h2>
        </div>
        <div class="col-md-12">
          <div>
            <p class="ml-2 lead">{{ this.group.description }}</p>
            <hr>
          </div>
        </div>
        <div class="col-md-12">
          <a href="#" @click="newModal" class="btn btn-success float-right mb-3">Agregar persona beneficiaria <i class="fas fa-plus"></i></a>
        </div>
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <p class="h4">Personas beneficiarias</p>
            </div>
            <div class="card-body">
              <p class="text-uppercase">
                <i class="fas fa-tools"></i> {{ group.evaluation }}
              </p>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">
                        <span class="table-headers">Folio</span>
                        
                      </th>
                      <th class="table-name" scope="col">
                        <span class="table-headers">Nombre</span>
                      </th>
                      <th scope="col" class="text-center">
                        <span class="table-headers">Género</span>
                      </th>
                      <th scope="col" class="text-center">
                        Fecha de nacimiento
                      </th>
                      <th scope="col" class="text-center">
                        No. de tomas
                      </th>
                      <th scope="col" class="text-center">
                        <span class="table-headers">Estatus</span>
                      </th>
                      <th class="text-center">
                        Nueva toma
                      </th>
                      <th>
                        <span class="table-headers">Progreso</span>
                      </th>
                      <th>
                        <span class="table-headers">Editar</span>
                      </th>
                      <th v-if="$gate.isAdminOrAuthor()"><span class="table-headers">Eliminar</span></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="beneficiary in group.beneficiaries" v-show="beneficiary.group_id == group.id">
                      <th>
                        <span v-if="beneficiary.birthdate">
                          {{ beneficiary.folio }}
                        </span>
                        <span v-else>
                          {{ beneficiary.folio }}XXXX
                        </span>
                      </th>
                      <td>{{ beneficiary.name }} {{ beneficiary.lastname_one }} {{ beneficiary.lastname_two }} </td>
                      <td class="text-center">{{ beneficiary.gender }}</td>
                      <td class="text-center">
                        <span v-if="beneficiary.birthdate">
                          {{ beneficiary.birthdate | myDate }}
                        </span>
                        <span v-else>
                          N/A
                        </span>
                      </td>
                      
                      <td class="text-center">
                        <span v-if="group.evaluation == 'yttv1'">
                          {{ beneficiary.ytt1_evaluations.length }}
                        </span>
                        <span v-else>
                          {{ beneficiary.ytt2_evaluations.length }}
                        </span>
                      </td>
                      <td class="text-center">
                        <span v-if="beneficiary.birthdate">
                          Completo
                          <i class="fas fa-check-circle text-success"></i>
                        </span>
                        <span v-else>
                          Incompleto
                          <i class="fas fa-exclamation-circle text-danger"></i>
                        </span>
                      </td>
                      <td class="text-center">
                        <a class="pointer" @click="sendToEvaluation(beneficiary)">
                          <i class="fas fa-file-invoice" style="color:black;"></i>
                        </a>
                      </td>
                      <td class="text-center">
                        <a class="pointer" @click="sendToBeneficiary(beneficiary.folio)">
                          <i class="fa fa-chart-line" style="color:grey;"></i>
                        </a>
                      </td>
                      <td class="text-center">
                        <a href="#" @click="editModal(beneficiary)">
                          <i class="fa fa-edit blue"></i>
                        </a>
                      </td>
                      <td class="text-center" v-if="$gate.isAdminOrAuthor()">
                        <a href="#" @click="deleteBeneficiary(beneficiary.id)">
                          <i class="fa fa-trash red"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <button type="button" class="btn btn-primary mb-3" name="button" @click.prevent="printme">
            Imprimir
            <i class="fas fa-print"></i>
          </button>
        </div>
      </div>
    </div>
    <!-- Content Header (Page header) -->
    <!-- Modal -->
    <div class="modal fade" id="addNewGroup" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Agregar beneficiario</h5>
            <h5 class="modal-title" v-show="editmode" id="addNewLabel">Editar beneficiario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editmode ? updateBeneficiary() : createBeneficiary()">
            <div class="modal-body">
              <div class="form-group">
                <label>Primer apellido</label>
                <input v-model="form.lastname_one" type="text" name="lastname_one"
                placeholder="Primer apellido"
                class="form-control" :class="{ 'is-invalid': form.errors.has('lastname_one') }">
                <has-error :form="form" field="lastname_one"></has-error>
              </div>

              <div class="form-group">
                <label>Segundo apellido</label>
                <input v-model="form.lastname_two" type="text" name="lastname_two"
                placeholder="Segundo apellido"
                class="form-control" :class="{ 'is-invalid': form.errors.has('lastname_two') }">
                <has-error :form="form" field="lastname_two"></has-error>
              </div>

              <div class="form-group">
                <label>Nombre</label>
                <input v-model="form.name" type="text" name="name"
                placeholder="Nombre"
                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                <has-error :form="form" field="name"></has-error>
              </div>

              <div class="form-group">
                <label>Fecha de nacimiento</label>
                <input v-model="form.birthdate" type="date" name="birthdate"
                placeholder="Fecha de nacimiento"
                class="form-control" :class="{ 'is-invalid': form.errors.has('birthdate') }">
                <small id="emailHelp" class="form-text text-muted">Si no conoce la fecha de nacimiento dejar en blanco.</small>
                <has-error :form="form" field="birthdate"></has-error>
              </div>

              <div class="form-group">
                <label>Género</label>
                <select name="type" v-model="form.gender" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('gender') }">
                  <option value="">Selecciona el género del beneficiario</option>
                  <option value="masculino">Masculino</option>
                  <option value="femenino">Femenino</option>
                  <option value="otro">Otro</option>
                </select>
                <has-error :form="form" field="gender"></has-error>
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
      loading: false,
      editmode: false,
      group:[],
      form: new Form({
        id: '',
        lastname_one : '',
        lastname_two : '',
        name: '',
        birthdate: '',
        gender: '',
        folio: '',
        group_id: ''
      })
    }
  },
  methods:{
    sendToBeneficiary(folio){
      this.$router.push(`/group/${this.$route.params.group}/${folio}`)
    },
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
            this.$router.push(`/group/${this.$route.params.group}/${beneficiary.folio}/evaluation`)
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
            this.$router.push(`/group/${this.$route.params.group}/${beneficiary.folio}/evaluation`)
          }
        })
      } else {
        this.$router.push(`/group/${this.$route.params.group}/${beneficiary.folio}/evaluation`)
      }
    },
    printme(){
      window.print();
    },
    loadData(){
      this.loading = true;
      axios.get(`/api/group_by_slug/${this.$route.params.group}`)
      .then(({data}) => (
        this.group = data,
        this.loading = false
      )).catch(()=>{
        this.$Progress.fail();
        toast({
          type: 'error',
          title: 'Error al cargar datos.'
        })
        this.loading = false;
      });
    },
    newModal(){
      this.editmode = false;
      this.form.reset();
      $('#addNewGroup').modal('show');
    },
    createBeneficiary(){
      this.$Progress.start();

      this.form.group_id = this.group.id;

      this.form.folio = (this.form.lastname_one.substring(0,2) +  this.form.lastname_two.substring(0,2) +  this.form.name.substring(0,2)).toUpperCase() + this.form.birthdate.substring(2,4) + this.form.birthdate.substring(5,7) + this.form.birthdate.substring(8,10)

      this.form.post('/api/beneficiary')
      .then(()=>{
        Fire.$emit('AfterCreate');
        $('#addNewGroup').modal('hide')

        toast({
          type: 'success',
          title: 'Persona beneficiaria creada.'
        })
        this.$Progress.finish();
      })
      .catch(()=>{
        this.$Progress.fail();
        toast({
          type: 'error',
          title: 'Error al crear persona beneficiaria.'
        })
      })
    },
    editModal(beneficiary){
      this.editmode = true;
      this.form.reset();
      $('#addNewGroup').modal('show');
      this.form.fill(beneficiary);
    },
    updateBeneficiary(){
      this.$Progress.start();
      this.form.folio = (this.form.lastname_one.substring(0,2) +  this.form.lastname_two.substring(0,2) +  this.form.name.substring(0,2)).toUpperCase() + this.form.birthdate.substring(2,4) + this.form.birthdate.substring(5,7) + this.form.birthdate.substring(8,10)
      // console.log('Editing data');
      this.form.put('/api/beneficiary/'+this.form.id)
      .then(() => {
        // success
        $('#addNewGroup').modal('hide');
        swal(
          'Actualizado',
          'La información de la persona beneficiaria se ha actualizado.',
          'success'
        )
        this.$Progress.finish();
        Fire.$emit('AfterCreate');
      })
      .catch(() => {
        this.$Progress.fail();
      });
    },
    deleteBeneficiary(id){
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

        // Send request to the server
        if (result.value) {
          this.form.delete('/api/beneficiary/'+id).then(()=>{
            swal(
              '¡Eliminado!',
              'Persona beneficiaria eliminada.',
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
.table-headers {
  position: relative;
    bottom: 1em;
}
.table-name {
  min-width: 14rem !important;
}
</style>
