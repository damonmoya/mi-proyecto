@extends('layout')

@section('title', "Usuarios")

@section('header')
    <h1 class="mb-3">{{ $title }}</h1>
@endsection

@section('content')

    <div id="control_usuario">

        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
            <div class="form-group mt-2 mt-md-0 mb-3 row align-items-end">
                <div class="col-10">
                    Buscar usuario: <input type="text" v-model="keywords">
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
            <tbody>
                    <tr v-for="user in users">
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
            },
            data: {
                users: [],
                newUserName: '',
                newUserEmail: '',
                newUserPassword: '',
                newUserConfirm_password: '',
                fillUser: {'id': '', 'name': '', 'email': '', 'password': '', 'confirm_password': ''},
                errors: new Errors()
            },
            methods: {
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
                    $('#editUserModal').modal('show');
                },
                updateUser: function(id) {
                    var url = '/usuarios/recursos/' + id;
                    axios.put(url, {
                        name: this.fillUser.name,
                        email: this.fillUser.email,
                        password: this.fillUser.password,
                        confirm_password: this.fillUser.confirm_password
                    }).then(response => {
                        this.getUsers();
                        var msg = '¡Se ha editado el usuario ' + this.fillUser.name + ' correctamente!';
                        toastr.success(msg);
                        this.fillUser = {'id': '', 'name': '', 'email': '', 'password': '', 'confirm_password': ''};
                        this.errors.reset();
                        $('#editUserModal').modal('hide');
                    }).catch(error => 
                        this.errors.record(error.response.data.errors)
                    );
                },
                deleteUser: function(user) {
                    var url = '/usuarios/recursos/' + user.id;
                    var userName = user.name;
                    var msg = '¡Usuario ' + userName + ' eliminado correctamente!';
                    axios.delete(url).then(response => {
                        this.getUsers();  
                        toastr.success(msg);
                    });
                },
                createUser: function() {
                    var url = '/usuarios/recursos';
                    axios.post(url, {
                        name: this.newUserName,
                        email: this.newUserEmail,
                        password: this.newUserPassword,
                        confirm_password: this.newUserConfirm_password
                    }).then(response => {
                        this.getUsers();
                        var msg = '¡Se ha creado el usuario ' + this.newUserName + ' correctamente!';
                        toastr.success(msg);
                        this.name = '';
                        this.email = '';
                        this.password = '';
                        this.confirm_password = '';
                        this.errors.reset();
                        $('#createUserModal').modal('hide');
                    }).catch(error => 
                        this.errors.record(error.response.data.errors)
                    );
                }
            }
        })

</script>

@endsection