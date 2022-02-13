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
                        <i class="fa fa-align-justify"></i> Roles
                        <button type="button" @click="openModal('role_type','register')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Crear
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterion">
                                      <option value="id">id</option>
                                      <option value="name">Nombre</option>
                                      <option value="name_screen">Nombre en pantalla</option>
                                    </select>
                                    <input type="text" v-model="search" @keyup.enter="getRoles(1,search,criterion)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="getRoles(1,search,criterion)"  class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Codigo Rol</th>
                                    <th>Nombre</th>
                                    <th>Nombre en pantalla</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="rol in arrayRoles" :key="rol.id">
                                    <td v-text="rol.id"></td>
                                    <td v-text="rol.name"></td>
                                    <td v-text="rol.name_screen"></td>
                                    <td>
                                        <button type="button" @click="openModal('role_type','update',rol)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <button type="button" @click="deleteRol(rol.id)" class="btn btn-danger btn-sm">
                                          <i class="icon-trash"></i>
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
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="name"  class="form-control">
                                        <span class="help-block">(*) Ingrese el nombre del rol</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Nombre en pantalla</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="name_screen"  class="form-control">
                                        <span class="help-block">(*) Ingrese el nombre del rol en pantalla</span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="closeModal()">  Cerrar</button>
                            <button type="button" v-if="typeAction == 1" class="btn btn-primary" @click="createRol()"> Guardar</button>
                            <button type="button" v-if="typeAction == 2" class="btn btn-primary" @click="updateRol()"> Actualizar</button>
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
            role_id : 0,
            name : '',
            name_screen: '',
            arrayRoles : [],
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
            criterion : 'name',
            search : ''
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
        getRoles(page,search,criterion){
        let me = this;
        var url = '/api/getRoles?page='+page+'&search='+search+'&criterion='+criterion;
            axios.get(url)
  .then(function (response) {
      var serverResponse = response.data;
      me.arrayRoles = serverResponse.roles.data;
      me.pagination = serverResponse.pagination;
  })
  .catch(function (error) {
    // handle error
    console.log(error);
  });
        },
changePage(page, search, criterion){
    let me= this;
    me.pagination.current_page = page;
    me.getRoles(page, search, criterion);
},
        createRol(){
            let me = this;
            axios.post('/api/createRol', {
            'name': this.name,
            'name_screen' : this.name_screen
        })
        .then(function (response) {
            me.closeModal();
            me.getRoles(1, '', 'name');
              Swal.fire({
            icon: 'success',
            title: 'Exito',
            text: response.data,
            });
        })
        .catch(e => {
  Swal.fire({
  icon: 'error',
  title: 'Error al registrar el rol',
  text: this.validateErrors(e) ,
});
        });
        },
        updateRol(){
                      let me = this;
            axios.put('/api/updateRol/'+this.role_id, {
            'name': this.name,
            'name_screen' : this.name_screen
        })
        .then(function (response) {
            me.closeModal();
            me.getRoles(1,'','name');
              Swal.fire({
            icon: 'success',
            title: 'Exito',
            text: response.data,
            });
        })
        .catch(e => {
  Swal.fire({
  icon: 'error',
  title: 'Error al actualizar el rol',
  text: this.validateErrors(e) ,
});
        });  
        },
        deleteRol(id){
            Swal.fire({
  title: 'Confirmacion de eliminacion',
  text: "¿Estas seguro de eliminar el rol?",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Si, eliminar'
}).then((result) => {
  if (result.isConfirmed) {
                      let me = this;
            axios.delete('/api/deleteRol/'+id)
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
  title: 'Error al eliminar el rol',
  text: e.response.data ,
});
        }); 
    me.getRoles(1, '', 'name');
  }
});
        },
        openModal(model, action, data=[]){
            switch(model){
                case 'role_type':{
                    switch(action){
                        case 'register':{
                            this.modal = 1;
                            this.name = '';
                            this.name_screen = '';
                            this.titleModal = 'Registrar Rol';
                            this.typeAction = 1;
                            break;
                        }
                        case  'update' :{
                            this.modal = 1;
                            this.titleModal = 'Actualizar Rol';
                            this.typeAction = 2;
                            this.name = data['name'];
                            this.name_screen = data['name_screen'];
                            this.role_id = data['id'];
                        }
                    }
                }
            }
        },
        closeModal(){
            this.modal = 0;
            this.titleModal = '';
            this.name = '';
            this.name_screen = '';
        },
        validateErrors(e){
            let error ='';
    if(e.response.data.name != null  && +e.response.data.name_screen != null){
 error = e.response.data.name+'. '+e.response.data.name_screen;
    }else if(e.response.data.name != null && e.response.data.name_screen == null){
  error = e.response.data.name;
    }else if(e.response.data.name == null && e.response.data.name_screen != null){
          error = e.response.data.name_screen;
    }
    return error;
        }
    },
                mounted(){
           this.getRoles(1,this.search,this.criterion);
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