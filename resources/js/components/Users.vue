<template>
        <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Usuarios
                        <button v-show="rolUserAuthenticated == 1"  type="button" @click="openModal('users','register')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Crear
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterion">
                                      <option value="id">id</option>
                                      <option value="nombre">Nombre</option>
                                      <option value="email">Correo electronico</option>
                                    </select>
                                    <input type="text" v-model="search" @keyup.enter="getUsers(1,search,criterion)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="getUsers(1,search,criterion)"  class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Cedula</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                    <th v-show="rolUserAuthenticated == 1" >Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in arrayUsers" :key="user.id">
                                    <td v-text="user.id"></td>
                                    <td v-text="user.nombre"></td>
                                    <td v-text="user.email"></td>
                                    <td v-text="user.name_screen"></td>
                                    <td v-show="user.user_status == 0">Inactivo</td>
                                    <td v-show="user.user_status == 1">Activo</td>
                                    <td v-show="rolUserAuthenticated == 1">
                                        <button v-show="rolUserAuthenticated == 1" type="button" @click="openModal('users','update',user)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <button v-show="rolUserAuthenticated == 1"  type="button" @click="deleteUser(user.id)" class="btn btn-danger btn-sm">
                                          <i class="icon-trash"></i>
                                        </button>

                                        <button v-show="user.user_status == 0 && rolUserAuthenticated == 1" type="button" @click="updateStateUser(user.id, 1)" class="btn btn-success btn-sm">
                                          Activar
                                        </button>
                                        <button  v-show="user.user_status == 1 && rolUserAuthenticated == 1" type="button" @click="updateStateUser(user.id, 0)" class="btn btn-danger btn-sm">
                                            Inactivar
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page - 1,search,criterion)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="changePage(page,search,criterion)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page + 1,search,criterion)">Sig</a>
                                </li>
                        &nbsp; &nbsp;
                                <li>
                                <a v-show="rolUserAuthenticated == 1" href="/reports/excel/users" class="btn btn-success">Generar Reporte Excel</a>
                            </li>
                            &nbsp; &nbsp;
                            <li>
                            <select v-show="rolUserAuthenticated == 1" class="form-control" v-model="id_role"  v-on:change="generatePDF($event)">
                                            <option value="0" disabled>Generar PDF</option>
                                            <option v-for="rol in arrayRoles" :key="rol.id" :value="rol.name" v-text="rol.name">  </option>
                                        </select>  
                            </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade"  tabindex="-1" :class="{'show' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-danger modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="titleModal"></h4>
                            <button type="button" class="close" @click="closeModal()" aria-label="Close">
                              <span aria-hidden="true">X</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div  v-if="typeAction == 1" class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Cedula</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="user_id"  class="form-control">
                                        <span class="help-block">(*) Ingrese la cedula</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre"  class="form-control">
                                        <span class="help-block">(*) Ingrese el nombre</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Correo</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="email"  class="form-control">
                                        <span class="help-block">(*) Ingrese el correo</span>
                                    </div>
                                </div>

                                <div v-if="typeAction == 1" class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Contraseña</label>
                                    <div class="col-md-9">
                                        <input type="password" v-model="password"  class="form-control">
                                        <span class="help-block">(*) Ingrese la contraseña</span>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Rol</label>
                                    <div class="col-md-9">
                                     <select class="form-control" v-model="id_role">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="rol in arrayRoles" :key="rol.id" :value="rol.id" v-text="rol.name_screen"></option>
                                        </select>   
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="closeModal()">  Cerrar</button>
                            <button type="button" v-if="typeAction == 1" class="btn btn-primary" @click="createUser()"> Guardar</button>
                            <button type="button" v-if="typeAction == 2" class="btn btn-primary" @click="updateUser()"> Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
            <!-- Inicio del modal Eliminar -->
            <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-danger" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Eliminar Categoría</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Estas seguro de eliminar la categoría?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-danger">Eliminar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- Fin del modal Eliminar -->
        </main>
</template>

<script>
import Swal from 'sweetalert2'
    export default {
    data(){
        return{
            user_id : 0,
            nombre: '',
            email : '',
            password :'',
            id_role:0,
            arrayRoles : [],
            arrayUsers: [],
            modal : 0,
            titleModal : '',
            typeAction : 0,
            errors : '',
            pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
            },
            numberOfRecords : 3,
            criterion : 'nombre',
            search : '',
            rolUserAuthenticated : 0
        }
    },
    computed:{
           isActived: function(){
                return this.pagination.current_page;
            },
                //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.numberOfRecords; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.numberOfRecords * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             
            }
    },
    methods:{
        getUserAuthenticated(){
        let me = this;
        var url = '/getUserAuthenticated';
            axios.get(url)
  .then(function (response) {
      me.rolUserAuthenticated = response.data.user.id_role;
      console.log(me.rolUserAuthenticated);
  })
  .catch(function (error) {
    console.log(error);
  });
        },
        getUsers(page,search,criterion){
        let me = this;
        var url = '/api/getUsers?page='+page+'&search='+search+'&criterion='+criterion;
            axios.get(url)
  .then(function (response) {
      var serverResponse = response.data;
      me.arrayUsers = serverResponse.users.data;
      me.pagination = serverResponse.pagination;
  })
  .catch(function (error) {
    // handle error
    console.log(error);
  });
  this.getRoles();
        },
generatePDF(role){
    let value = role.target.value;
    window.open('/reports/users/'+value);
},
getRoles(){
    let me=this;
    var url = '/api/getRolesSelect';
    axios.get(url).then(function (response) {
    var respuesta= response.data;
    me.arrayRoles = respuesta.roles;
    })
    .catch(function (error) {
        console.log(error);
    });
},
changePage(page, search, criterion){
    let me= this;
    me.pagination.current_page = page;
    me.getUsers(page, search, criterion);
},
        createUser(){
            let me = this;
            axios.post('/api/createUser', {
            'id': this.user_id,
            'nombre' : this.nombre,
            'email' : this.email,
            'password' :this.password,
            'id_role' : this.id_role
        })
        .then(function (response) {
            me.closeModal();
            me.getUsers(1, '', 'nombre');
              Swal.fire({
            icon: 'success',
            title: 'Exito',
            text: response.data,
            });
        })
        .catch(e => {
            console.log(e.response.data);
  Swal.fire({
  icon: 'error',
  title: 'Error al registrar el usuario',
  text: '' ,
});
        });
        },
        updateUser(){
                      let me = this;
            axios.put('/api/updateUser/'+this.user_id, {
            'nombre' : this.nombre,
            'email' : this.email,
            'id_role' : this.id_role
        })
        .then(function (response) {
            me.closeModal();
            me.getUsers(1,'','nombre');
              Swal.fire({
            icon: 'success',
            title: 'Exito',
            text: response.data,
            });
        })
        .catch(e => {
                        console.log(e.response.data);
  Swal.fire({
  icon: 'error',
  title: 'Error al actualizar el usuario',
  text: '',
});
        });  
                   this.getUserAuthenticated();
        },
        deleteUser(id){
            Swal.fire({
  title: 'Confirmacion de eliminacion',
  text: "¿Estas seguro de eliminar el usuario?",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Si, eliminar'
}).then((result) => {
  if (result.isConfirmed) {
                      let me = this;
            axios.delete('/api/deleteUser/'+id)
        .then(function (response) {
    Swal.fire(
      'Eliminado',
      response.data,
      'success'
    );
        })
        .catch(e => {
  Swal.fire({
  icon: 'error',
  title: 'Error al eliminar el usuario',
  text: e.response.data ,
});
        }); 
    me.getUsers(1, '', 'nombre');
  }
});
        },
        updateStateUser(id, state){
                      let me = this;
            axios.put('/api/updateStateUser/'+id,{
            'user_status' : state
        })
        .then(function (response) {
            me.closeModal();
            me.getUsers(1,'','nombre');
              Swal.fire({
            icon: 'success',
            title: 'Exito',
            text: response.data,
            });
        })
        .catch(e => {
            console.log(e.response.data);
  Swal.fire({
  icon: 'error',
  title: 'Error al actualizar el usuario',
  text: ''
});
        });      
    me.getUsers(1, '', 'nombre');
        },
        openModal(model, action, data=[]){
            switch(model){
                case 'users':{
                    switch(action){
                        case 'register':{
                            this.modal = 1;
                            this.user_id = 0,
                            this.nombre = '';
                            this.email = '';
                            this.password = '';
                            this.id_role = 0;
                            this.titleModal = 'Registrar Usuario';
                            this.typeAction = 1;
                            this.id_role = 0;
                            break;
                        }
                        case  'update' :{
                            this.modal = 1;
                            this.titleModal = 'Actualizar Usuario';
                            this.typeAction = 2;
                            this.user_id = data['id'],
                            this.nombre = data['nombre'];
                            this.email = data['email'];
                            this.id_role = data['id_role'];
                        }
                    }
                }
            }
            this.getRoles();
        },
        closeModal(){
            this.modal = 0;
            this.titleModal = '';
            this.user_id = 0,
            this.nombre = '';
            this.email = '';
            this.password = '';
            this.id_role = 0;
        }
    },
                mounted(){
           this.getUsers(1,this.search,this.criterion);
           this.getUserAuthenticated();
        }
    }
</script>

<style>
    .modal-content{
        width: 100% !important;
        position:  absolute !important;
    }
    .show{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
</style>