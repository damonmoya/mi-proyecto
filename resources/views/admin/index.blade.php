@extends('layout')

@section('title', "Panel de Administración")

@section('header')
    <h1 class="mb-3">{{ $title }}</h1>
@endsection

@section('content')
<div id="control_usuario">
    <h3 class="mb-3">Listado de usuarios</h1>

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <div class="form-group mt-2 mt-md-0 mb-3 row">
                <div class="col-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text" id="btnGroupAddon2"><span class="oi oi-magnifying-glass"></span></div>
                        </div>
                    <input class="form-control py-2 border-right-0 border" v-model="keywordsUsers" type="search" placeholder="Buscar usuario...">
                </div>
            </div>
        </div>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nombre</th>
            <th scope="col">Estado</th>
            <th scope="col">Acciones</th>
        </tr>
        </thead>
        <tbody v-if="users.length > 0">
                <tr v-for="user in users" :key="user.id">
                    <td> @{{ user.id }} </td>
                    <td> @{{ user.name }} </td>
                    <td v-if="user.deleted_at == null">
                        Registrado
                    </td>
                    <td v-else>
                        Eliminado (@{{ formatTimestamp(user.deleted_at) }})
                    </td>
                    <td v-if="user.deleted_at == null">
                        <a href='#' class='btn btn-danger' v-on:click.prevent="deleteUser(user)">Borrar</a> 
                    </td>
                    <td v-else>
                        <a href='#' class='btn btn-primary' v-on:click.prevent="restoreUser(user)">Recuperar</a> 
                        <a href='#' class='btn btn-danger' v-on:click.prevent="eliminateUser(user)">Eliminar</a>
                    </td>
                </tr>
        </tbody>
    </table>

</div>


<script>
    const app = new Vue({ 
        el: '#control_usuario',
        created: function() {
            this.fetchUsers();
        },
        data: {
            keywordsUsers: null,
            users: []
        },
        watch: {
          keywordsUsers(after, before) {
              this.fetchUsers();
          }
        },
        methods: {
            fetchUsers() {
                axios.get("{{ route('admin.searchUsers') }}", { params: { keywords: this.keywordsUsers } })
                    .then(response => this.users = response.data)
                    .catch(error => {});
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
                        var msg = '¡Usuario ' + userName + ' borrado correctamente!';
                        axios.delete(url).then(response => {
                            this.fetchUsers();  
                            toastr.success(msg, "Usuario borrado", {"positionClass": "toast-bottom-right"});
                        });
                    }
                });
            },
            restoreUser: function(user) {
                var userName = user.name;
                var msg = '¿Restaurar el usuario "' + userName + '"?';
                swal({
                    title: "Restaurar usuario",
                    text: msg,
                    icon: "info",
                    buttons: true,
                })
                .then((willRestore) => {
                    if (willRestore) {
                        var url = '/admin/' + user.id + '/restaurar';
                        var msg = '¡Usuario ' + userName + ' restaurado correctamente!';
                        axios.get(url).then(response => {
                            this.fetchUsers();  
                            toastr.success(msg, "Usuario restaurado", {"positionClass": "toast-bottom-right"});
                        });
                    }
                });
            },
            formatTimestamp: function(date) {
        		return moment(date, 'DD/MM/YYYY').format('YYYY-MM-DD');
        	},
            eliminateUser: function(user) {
                var userName = user.name;
                var msg = '¿Eliminar el usuario "' + userName + '"?';
                swal({
                    title: "Eliminar usuario",
                    text: msg,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willRestore) => {
                    if (willRestore) {
                        var url = '/admin/' + user.id + '/eliminar';
                        var msg = '¡Usuario ' + userName + ' eliminado correctamente!';
                        axios.get(url).then(response => {
                            this.fetchUsers();  
                            toastr.success(msg, "Usuario eliminado", {"positionClass": "toast-bottom-right"});
                        });
                    }
                });
            }
        }
    })

</script>
            
@endsection