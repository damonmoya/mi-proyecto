@extends('layout')

@section('title', "Usuarios")

@section('header')
    <h1 class="mb-3">{{ $title }}</h1>
@endsection

@section('content')

    <div id="control_usuario">

        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <div class="form-group mt-2 mt-md-0 mb-3 row">
                    <div class="col-10">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text" id="btnGroupAddon2"><span class="oi oi-magnifying-glass"></span></div>
                            </div>
                        <input class="form-control py-2 border-right-0 border" v-model="keywords" type="search" placeholder="Buscar usuario">
                    </div>
                </div>
                @hasrole('Administrador')
                    <div class="col-2">
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#createUserModal">Crear usuario</a>
                    </div>
                @endhasrole
            </div>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Correo</th>
                <th scope="col">Acciones</th>
            </tr>
            </thead>
            <tbody v-if="users.length > 0">
                    <tr v-for="user in users" :key="user.id">
                        <td> @{{ user.id }} </td>
                        <td> @{{ user.name }} </td>
                        <td> @{{ user.email }} </td>
                        <td>
                            <a :href="'/usuarios/' + user.id" class='btn btn-info'><span class='oi oi-eye'></span></a>
                            @hasrole('Administrador')
                                <a href='#' class='btn btn-primary' v-on:click.prevent="editUser(user)"><span class='oi oi-pencil'></span></a> 
                                <a href='#' class='btn btn-danger' v-on:click.prevent="deleteUser(user)"><span class='oi oi-trash'></span></a>
                            @endhasrole
                        </td>
                    </tr>
            </tbody>
        </table>

        @include('users.create')
        @include('users.edit')

    </div>
        
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>

        class Errors {
            constructor() {
                this.errors = {};
            }

            get(field){
                if (this.errors[field]) {
                    return this.errors[field][0];
                }
            }

            record(errors) {
                this.errors = errors;
            }

            reset(){
                this.errors = {}; 
            }

        }

        const app = new Vue({ 
            el: '#control_usuario',
            created: function() {
                this.getUsers();
                this.getDepartments();
                this.getProfessions();
            },
            data: {
                keywords: null,
                users: [],
                departments: [],
                professions: [],
                newUserName: '',
                newUserEmail: '',
                newUserPassword: '',
                newUserConfirm_password: '',
                newUserDepartment: '',
                newUserProfession: '',
                fillUser: {'id': '', 'name': '', 'email': '', 'password': '', 'confirm_password': '', 'department_id': '', 'profession_id': ''},
                errors: new Errors()
            },
            watch: {
                keywords(after, before) {
                    this.fetch();
                }
            },
            methods: {
                fetch() {
                    axios.get('/usuarios/search', { params: { keywords: this.keywords } })
                        .then(response => this.users = response.data)
                        .catch(error => {});
                },
                clearErrors: function(){
                    this.errors.reset();
                },
                getUsers: function(){
                    var urlUsers = '/usuarios/recursos';
                    axios.get(urlUsers).then(response => {
                        this.users = response.data
                    });
                },
                editUser: function(user) {
                    this.fillUser.id = user.id;
                    this.fillUser.name = user.name;
                    this.fillUser.email = user.email;
                    this.fillUser.department_id = user.department_id;
                    this.fillUser.profession_id = user.profession_id;
                    $('#editUserModal').modal('show');
                },
                updateUser: function(id) {
                    var url = '/usuarios/recursos/' + id;
                    axios.put(url, {
                        name: this.fillUser.name,
                        email: this.fillUser.email,
                        password: this.fillUser.password,
                        confirm_password: this.fillUser.confirm_password,
                        department_id: this.fillUser.department_id,
                        profession_id: this.fillUser.profession_id,
                    }).then(response => {
                        this.getUsers();
                        var msg = '¡Se ha editado el usuario ' + this.fillUser.name + ' correctamente!';
                        toastr.success(msg, "Usuario modificado", {"positionClass": "toast-bottom-right"});
                        this.fillUser = {'id': '', 'name': '', 'email': '', 'password': '', 'confirm_password': '', 'department_id': '', 'profession_id': ''};
                        this.errors.reset();
                        $('#editUserModal').modal('hide');
                    }).catch(error => {
                        this.errors.record(error.response.data.errors);
                        toastr.error("No se ha podido actualizar el usuario, por favor revisa los errores", "Error al editar usuario", {"positionClass": "toast-bottom-right"});
                    });
                },
                deleteUser: function(user) {
                    var userName = user.name;
                    var msg = '¿Borrar el usuario "' + userName + '"?';
                    swal({
                        title: "Borrar usuario",
                        text: msg,
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            var url = '/usuarios/recursos/' + user.id;
                            var msg = '¡Usuario ' + userName + ' eliminado correctamente!';
                            axios.delete(url).then(response => {
                                this.getUsers();  
                                toastr.success(msg, "Usuario eliminado", {"positionClass": "toast-bottom-right"});
                            });
                        }
                    });
                },
                createUser: function() {
                    var url = '/usuarios/recursos';
                    axios.post(url, {
                        name: this.newUserName,
                        email: this.newUserEmail,
                        password: this.newUserPassword,
                        confirm_password: this.newUserConfirm_password,
                        department_id: this.newUserDepartment,
                        profession_id: this.newUserProfession
                    }).then(response => {
                        this.getUsers();
                        var msg = '¡Se ha creado el usuario ' + this.newUserName + ' correctamente!';
                        toastr.success(msg, "Usuario creado", {"positionClass": "toast-bottom-right"});
                        this.name = '';
                        this.email = '';
                        this.password = '';
                        this.confirm_password = '';
                        this.department_id = '';
                        this.profession_id = '';
                        this.errors.reset();
                        $('#createUserModal').modal('hide');
                    }).catch(error => {
                        this.errors.record(error.response.data.errors);
                        toastr.error("No se ha podido crear el usuario, por favor revisa los errores", "Error al crear usuario", {"positionClass": "toast-bottom-right"});
                    });
                },
                onChange(event) {
                    this.newUserDepartment= '';
                    this.fillUser.department_id= '';
                    axios.get('/empresas/dependents', { params: { company: event.target.value } })
                        .then(response => this.departments = response.data)
                        .catch(error => {});
                },
                onEdit(id) {
                    axios.get('/empresas/dependents', { params: { company: id} })
                        .then(response => this.departments = response.data)
                        .catch(error => {});
                    this.getCompanies();
                },
                getDepartments: function(){
                    var urlDepartment = '/departamentos/recursos';
                    axios.get(urlDepartment).then(response => {
                        this.departments = response.data
                    });
                },
                getProfessions: function(){
                    var urlProfession = '/profesiones/recursos';
                    axios.get(urlProfession).then(response => {
                        this.professions = response.data
                    });
                }
            }
        })

</script>

@endsection