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
            <div class="col-sm-6">
              <h1>
                {{ group.name }}
              </h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                  <router-link to="/home">Grupos</router-link>
                </li>
                <li class="breadcrumb-item active">{{ group.name }}</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <div class="row">
        <div class="col-md-12">
          <div>
            <p class="ml-2 lead">{{ this.group.description }}</p>
            <hr>
          </div>
        </div>
        <div class="col-md-12">
          <a href="#" @click="newModal" class="btn btn-success float-right mb-3">Agregar beneficiario <i class="fas fa-plus"></i></a>
        </div>
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3>Personas beneficiarias</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Folio</th>
                      <th scope="col">Nombre</th>
                      <th scope="col">Género</th>
                      <th scope="col">Fecha de nacimiento</th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th v-if="$gate.isAdminOrAuthor()"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="beneficiary in beneficiaries" v-show="beneficiary.group_id == group.id">
                      <th>{{ beneficiary.folio }}</th>
                      <td>{{ beneficiary.name }} {{ beneficiary.lastname_one }} {{ beneficiary.lastname_two }} </td>
                      <td>{{ beneficiary.gender }}</td>
                      <td>{{ beneficiary.birthdate | myDate }}</td>
                      <td>
                        <router-link :to="{ name: 'Evaluation', params: { beneficiary } }">
                          <i class="fas fa-file-invoice" style="color:black;"></i>
                        </router-link>
                      </td>
                      <td>
                        <router-link :to="'/beneficiary/'+beneficiary.id">
                          <i class="fa fa-chart-line" style="color:grey;"></i>
                        </router-link>
                      </td>
                      <td>
                        <a href="#" @click="editModal(beneficiary)">
                          <i class="fa fa-edit blue"></i>
                        </a>
                      </td>
                      <td v-if="$gate.isAdminOrAuthor()">
                        <a href="#" @click="deleteBeneficiary(beneficiary.id)">
                          <i class="fa fa-trash red"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer">

            </div>
          </div>
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
                <input v-model="form.lastname_one" type="text" name="lastname_one"
                placeholder="Primer apellido"
                class="form-control" :class="{ 'is-invalid': form.errors.has('lastname_one') }">
                <has-error :form="form" field="lastname_one"></has-error>
              </div>

              <div class="form-group">
                <input v-model="form.lastname_two" type="text" name="lastname_two"
                placeholder="Segundo apellido"
                class="form-control" :class="{ 'is-invalid': form.errors.has('lastname_two') }">
                <has-error :form="form" field="lastname_two"></has-error>
              </div>

              <div class="form-group">
                <input v-model="form.name" type="text" name="name"
                placeholder="Nombre"
                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                <has-error :form="form" field="name"></has-error>
              </div>

              <div class="form-group">
                <input v-model="form.birthdate" type="date" name="birthdate"
                placeholder="Fecha de nacimiento"
                class="form-control" :class="{ 'is-invalid': form.errors.has('birthdate') }">
                <has-error :form="form" field="birthdate"></has-error>
              </div>

              <div class="form-group">
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
    <!-- Modal beneficiary -->
    <div class="modal fade" id="addShowBeneficiary" tabindex="-1" role="dialog" aria-labelledby="addShowBeneficiaryLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addShowBeneficiaryLabel">folio de beneficiario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
              Holi
            </div>
            <div class="modal-footer">
              boli
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
      beneficiary_selected: {},
      editmode: false,
      group:[],
      beneficiaries:{},
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
    loadData(){
      this.loading = true;
      axios.get('/api/group/'+this.$route.params.id).then(({data}) => (this.group = data));
      axios.get('/api/beneficiary/').then(({data}) => (
        this.beneficiaries = data,
        this.loading = false
      ));
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
        confirmButtonText: 'Eliminar'
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
</style>
