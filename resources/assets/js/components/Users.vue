<template>
  <div class="row">
    <div class="col-md-12">
      <button class="btn btn-success mb-3 float-right" @click="newModal">Agregar usuario <i class="fas fa-user-plus fa-fw"></i></button>
      <div class="table-responsive p-0">
        <table class="table table-hover">
          <tbody>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Correo</th>
              <th>Rol</th>
              <th>Organizacion</th>
              <th>Fecha de registro</th>
              <th>Editar</th>
              <th>Eliminar</th>
            </tr>


            <tr v-for="user in users.data" :key="user.id" v-show="user.organization_id == organizationSelected">

              <td>{{user.id}}</td>
              <td>{{user.name}}</td>
              <td>{{user.email}}</td>
              <td>{{user.type | upText}}</td>
              <td>{{user.organization.name}}</td>
              <td>{{user.created_at}}</td>

              <td>
                <a href="#" @click="editModal(user)">
                  <i class="fa fa-edit blue"></i>
                </a>
              </td>
              <td>
                <a href="#" @click="deleteUser(user.id)">
                  <i class="fa fa-trash red"></i>
                </a>
              </td>
            </tr>
          </tbody></table>
        </div>
        <div class="mt-3">
          <pagination :data="users" @pagination-change-page="getResults"></pagination>
        </div>
      </div>


      <!-- Modal -->
      <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Agregar nuevo</h5>
              <h5 class="modal-title" v-show="editmode" id="addNewLabel">Actualizar informacion</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form @submit.prevent="editmode ? updateUser() : createUser()">
              <div class="modal-body">
                <div class="form-group">
                  <input v-model="form.name" type="text" name="name"
                  placeholder="Nombre"
                  class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                  <has-error :form="form" field="name"></has-error>
                </div>

                <div class="form-group">
                  <input v-model="form.email" type="email" name="email"
                  placeholder="Correo"
                  class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                  <has-error :form="form" field="email"></has-error>
                </div>

                <div class="form-group">
                  <textarea v-model="form.bio" name="bio" id="bio"
                  placeholder="Breve descripcion"
                  class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                  <has-error :form="form" field="bio"></has-error>
                </div>


                <div class="form-group">
                  <select name="type" v-model="form.type" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                    <option value="">Selecciona el rol del usuario</option>
                    <option value="admin" v-show="$gate.isAdmin()">Administrador</option>
                    <option value="author">Director</option>
                    <option value="user">Capturista</option>
                  </select>
                  <has-error :form="form" field="type"></has-error>
                </div>

                <!-- <div class="form-group">
                  <input v-model="form.password" type="password" name="password" id="password" placeholder="Contraseña"
                  class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                  <has-error :form="form" field="password"></has-error>
                </div> -->

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button v-show="editmode" type="submit" class="btn btn-success">Actualizar</button>
                <button v-show="!editmode" type="submit" class="btn btn-primary" @click="generatePw">Crear</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </template>

  <script>
  export default {
    props: ['organizationSelected'],
    data() {
      return {
        editmode: false,
        users : {},
        form: new Form({
          id:'',
          name : '',
          email: '',
          password: '',
          type: '',
          bio: '',
          photo: 'profile.png',
          organization_id: '',
        })
      }
    },
    methods: {
      generatePw(){
        let today = new Date();
        let dd = String(today.getDate()).padStart(2, '0');
        let mm = String(today.getMonth() + 1).padStart(2, '0');
        let yyyy = today.getFullYear();
        this.$data.form.password = 'YttToolPwAutoGen' + yyyy + mm + dd;
        console.log(this.$data.form.password);
      },
      getResults(page = 1) {
        axios.get('api/user?page=' + page)
        .then(response => {
          this.users = response.data;
        });
      },
      updateUser(){
        this.$Progress.start();
        this.form.organization_id = this.$props.organizationSelected;
        
        // console.log('Editing data');
        this.form.put('api/user/'+this.form.id)
        .then(() => {
          // success
          $('#addNew').modal('hide');
          swal(
            'Actualizado!',
            'Información del usuario actualizada.',
            'success'
          )
          this.$Progress.finish();
          Fire.$emit('AfterCreate');
        })
        .catch(() => {
          this.$Progress.fail();
        });

      },
      editModal(user){
        this.editmode = true;
        this.form.reset();
        $('#addNew').modal('show');
        this.form.fill(user);
      },
      newModal(){
        this.editmode = false;
        this.form.reset();
        $('#addNew').modal('show');
      },
      deleteUser(id){
        swal({
          title: '¿Estás seguro?',
          text: "¡No podrás revertir esta acción!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Eliminar usuario',
          cancelButtonText: 'Cancelar'
        }).then((result) => {

          // Send request to the server
          if (result.value) {
            this.form.delete('api/user/'+id).then(()=>{
              swal(
                'Eliminado',
                'El usuario ha sido eliminado.',
                'success'
              )
              Fire.$emit('AfterCreate');
            }).catch(()=> {
              swal("Error", "Algo salió mal.", "warning");
            });
          }
        })
      },
      loadUsers(){
        if(this.$gate.isAdminOrAuthor()){
          axios.get("api/user").then(({ data }) => (this.users = data));
        }
      },

      createUser(){
        this.$Progress.start();

        this.form.organization_id = this.$props.organizationSelected;

        this.form.post('api/user')
        .then(()=>{
          Fire.$emit('AfterCreate');
          $('#addNew').modal('hide')

          toast({
            type: 'success',
            title: 'Usuario creado correctamente.'
          })
          this.$Progress.finish();

        })
        .catch(()=>{
          this.$Progress.fail();
        })
      }
    },
    created() {
      Fire.$on('searching',() => {
        let query = this.$parent.search;
        axios.get('api/findUser?q=' + query)
        .then((data) => {
          this.users = data.data
        })
        .catch(() => {

        })
      })
      this.loadUsers();
      Fire.$on('AfterCreate',() => {
        this.loadUsers();
      });
      //    setInterval(() => this.loadUsers(), 3000);
    }

  }
  </script>
