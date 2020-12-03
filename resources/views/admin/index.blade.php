@extends('layout')

@section('title', "Panel de Administración")

@section('header')
    <h1 class="mb-3">{{ $title }}</h1>
@endsection

@section('content')
<div id="control_admin">

    <div class="row align-items-end">
        <div class="col"><input type="radio" value="users" v-model="selected" @change="onChange($event)" name="users"> Usuarios<br></div>
        <div class="col"><input type="radio" value="professions" v-model="selected" @change="onChange($event)" name="professions"> Profesiones<br></div>
        <div class="col"><input type="radio" value="companies" v-model="selected" @change="onChange($event)" name="companies"> Empresas<br></div>
        <div class="col"><input type="radio" value="departments" v-model="selected" @change="onChange($event)" name="departments"> Departamentos<br></div>
    </div>


    <div>
        <h3 class="mb-3" v-show="selected === 'users'">Listado de usuarios</h1>
        <h3 class="mb-3" v-show="selected === 'professions'">Listado de profesiones</h1>
        <h3 class="mb-3" v-show="selected === 'companies'">Listado de empresas</h1>
        <h3 class="mb-3" v-show="selected === 'departments'">Listado de departamentos</h1>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <div class="form-group mt-2 mt-md-0 mb-3 row align-items-end">
                <div class="col-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text" id="btnGroupAddon2"><span class="oi oi-magnifying-glass"></span></div>
                        </div>
                    <input class="form-control py-2 border-right-0 border" v-model="keywordsUsers" v-show="selected === 'users'" type="search" placeholder="Buscar usuario...">
                    <input class="form-control py-2 border-right-0 border" v-model="keywordsProfessions" v-show="selected === 'professions'" type="search" placeholder="Buscar profesiones...">
                    <input class="form-control py-2 border-right-0 border" v-model="keywordsCompanies" v-show="selected === 'companies'" type="search" placeholder="Buscar empresas...">
                    <input class="form-control py-2 border-right-0 border" v-model="keywordsDepartments" v-show="selected === 'departments'" type="search" placeholder="Buscar departamentos...">
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
        <tbody v-show="selected === 'users'">
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
        <tbody v-show="selected === 'professions'">
                <tr v-for="profession in professions" :key="profession.id">
                    <td> @{{ profession.id }} </td>
                    <td> @{{ profession.title }} </td>
                    <td v-if="profession.deleted_at == null">
                        Registrado
                    </td>
                    <td v-else>
                        Eliminado (@{{ formatTimestamp(profession.deleted_at) }})
                    </td>
                    <td v-if="profession.deleted_at == null">
                        <a href='#' class='btn btn-danger' v-on:click.prevent="deleteProfession(profession)">Borrar</a> 
                    </td>
                    <td v-else>
                        <a href='#' class='btn btn-primary' v-on:click.prevent="restoreProfession(profession)">Recuperar</a> 
                        <a href='#' class='btn btn-danger' v-on:click.prevent="eliminateProfession(profession)">Eliminar</a>
                    </td>
                </tr>
        </tbody>
        <tbody v-show="selected === 'companies'">
                <tr v-for="company in companies" :key="company.id">
                    <td> @{{ company.id }} </td>
                    <td> @{{ company.name }} </td>
                    <td v-if="company.deleted_at == null">
                        Registrado
                    </td>
                    <td v-else>
                        Eliminado (@{{ formatTimestamp(company.deleted_at) }})
                    </td>
                    <td v-if="company.deleted_at == null">
                        <a href='#' class='btn btn-danger' v-on:click.prevent="deleteCompany(company)">Borrar</a> 
                    </td>
                    <td v-else>
                        <a href='#' class='btn btn-primary' v-on:click.prevent="restoreCompany(company)">Recuperar</a> 
                        <a href='#' class='btn btn-danger' v-on:click.prevent="eliminateCompany(company)">Eliminar</a>
                    </td>
                </tr>
        </tbody>
        <tbody v-show="selected === 'departments'">
                <tr v-for="department in departments" :key="department.id">
                    <td> @{{ department.id }} </td>
                    <td> @{{ department.name }} </td>
                    <td v-if="department.deleted_at == null">
                        Registrado
                    </td>
                    <td v-else>
                        Eliminado (@{{ formatTimestamp(department.deleted_at) }})
                    </td>
                    <td v-if="department.deleted_at == null">
                        <a href='#' class='btn btn-danger' v-on:click.prevent="deleteDepartment(department)">Borrar</a> 
                    </td>
                    <td v-else>
                        <a href='#' class='btn btn-primary' v-on:click.prevent="restoreDepartment(department)">Recuperar</a> 
                        <a href='#' class='btn btn-danger' v-on:click.prevent="eliminateDepartment(department)">Eliminar</a>
                    </td>
                </tr>
        </tbody>
    </table>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
<script>

    const app = new Vue({ 
        el: '#control_admin',
        created: function() {
            this.fetchUsers();
        },
        data: {
            selected: 'users',
            keywordsUsers: null,
            keywordsProfessions: null,
            keywordsCompanies: null,
            keywordsDepartments: null,
            users: [],
            professions: [],
            companies: [],
            departments: []
        },
        watch: {
            keywordsUsers(after, before) {
                this.fetchUsers();
            },
            keywordsProfessions(after, before) {
                this.fetchProfessions();
            },
            keywordsCompanies(after, before) {
                this.fetchCompanies();
            },
            keywordsDepartments(after, before) {
                this.fetchDepartments();
            }
        },
        methods: {
            formatTimestamp: function(date) {
        		return moment(date).format('DD-MM-YYYY | hh:mm a');
            },
            onChange(event) {
                if (event.target.value == "users"){
                    this.fetchUsers();
                }
                if (event.target.value == "professions"){
                    this.fetchProfessions();
                }
                if (event.target.value == "companies"){
                    this.fetchCompanies();
                }
                if (event.target.value == "departments"){
                    this.fetchDepartments();
                }
            },
            fetchUsers() {
                axios.get("{{ route('admin.searchUsers') }}", { params: { keywords: this.keywordsUsers } })
                    .then(response => this.users = response.data)
                    .catch(error => {});
            },
            fetchProfessions() {
                axios.get("{{ route('admin.searchProfessions') }}", { params: { keywords: this.keywordsProfessions } })
                    .then(response => this.professions = response.data)
                    .catch(error => {});
            },
            fetchCompanies() {
                axios.get("{{ route('admin.searchCompanies') }}", { params: { keywords: this.keywordsCompanies } })
                    .then(response => this.companies = response.data)
                    .catch(error => {});
            },
            fetchDepartments() {
                axios.get("{{ route('admin.searchDepartments') }}", { params: { keywords: this.keywordsDepartments } })
                    .then(response => this.departments = response.data)
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
                        var url = '/admin/' + user.id + '/restaurarUsuario';
                        var msg = '¡Usuario ' + userName + ' restaurado correctamente!';
                        axios.get(url).then(response => {
                            this.fetchUsers();  
                            toastr.success(msg, "Usuario restaurado", {"positionClass": "toast-bottom-right"});
                        });
                    }
                });
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
                .then((willEliminate) => {
                    if (willEliminate) {
                        var url = '/admin/' + user.id + '/eliminarUsuario';
                        var msg = '¡Usuario ' + userName + ' eliminado correctamente!';
                        axios.get(url).then(response => {
                            this.fetchUsers();  
                            toastr.success(msg, "Usuario eliminado", {"positionClass": "toast-bottom-right"});
                        });
                    }
                });
            },
            deleteProfession: function(profession) {
                var professionTitle = profession.title;
                var msg = '¿Borrar la profesión "' + professionTitle + '"?';
                swal({
                    title: "Borrar profesión",
                    text: msg,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var url = '/profesiones/recursos/' + profession.id;
                        var msg = 'Profesión ' + professionTitle + ' borrada correctamente!';
                        axios.delete(url).then(response => {
                            this.fetchProfessions();  
                            toastr.success(msg, "Profesión borrada", {"positionClass": "toast-bottom-right"});
                        });
                    }
                });
            },
            restoreProfession: function(profession) {
                var professionTitle = profession.title;
                var msg = '¿Restaurar la profesión "' + professionTitle + '"?';
                swal({
                    title: "Restaurar profesión",
                    text: msg,
                    icon: "info",
                    buttons: true,
                })
                .then((willRestore) => {
                    if (willRestore) {
                        var url = '/admin/' + profession.id + '/restaurarProfesion';
                        var msg = 'Profesión ' + professionTitle + ' restaurada correctamente!';
                        axios.get(url).then(response => {
                            this.fetchProfessions();  
                            toastr.success(msg, "Profesión restaurada", {"positionClass": "toast-bottom-right"});
                        });
                    }
                });
            },
            eliminateProfession: function(profession) {
                var professionTitle = profession.title;
                var msg = '¿Eliminar la profesión "' + professionTitle + '"?';
                swal({
                    title: "Eliminar profesión",
                    text: msg,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willEliminate) => {
                    if (willEliminate) {
                        var url = '/admin/' + profession.id + '/eliminarProfesion';
                        var msg = 'Profesión ' + professionTitle + ' eliminado correctamente!';
                        axios.get(url).then(response => {
                            this.fetchProfessions();  
                            toastr.success(msg, "Profesión eliminada", {"positionClass": "toast-bottom-right"});
                        });
                    }
                });
            },
            deleteCompany: function(company) {
                var companyName = company.name;
                var msg = '¿Borrar la empresa "' + companyName + '"?';
                swal({
                    title: "Borrar empresa",
                    text: msg,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var url = '/empresas/recursos/' + company.id;
                        var msg = '¡Empresa ' + companyName + ' borrada correctamente!';
                        axios.delete(url).then(response => {
                            this.fetchCompanies();  
                            toastr.success(msg, "Empresa borrada", {"positionClass": "toast-bottom-right"});
                        });
                    }
                });
            },
            restoreCompany: function(company) {
                var companyName = company.name;
                var msg = '¿Restaurar la empresa "' + companyName + '"?';
                swal({
                    title: "Restaurar empresa",
                    text: msg,
                    icon: "info",
                    buttons: true,
                })
                .then((willRestore) => {
                    if (willRestore) {
                        var url = '/admin/' + company.id + '/restaurarEmpresa';
                        var msg = 'Empresa ' + companyName + ' restaurada correctamente!';
                        axios.get(url).then(response => {
                            this.fetchCompanies();  
                            toastr.success(msg, "Empresa restaurada", {"positionClass": "toast-bottom-right"});
                        });
                    }
                });
            },
            eliminateCompany: function(company) {
                var companyName = company.name;
                var msg = '¿Eliminar la empresa "' + companyName + '"?';
                swal({
                    title: "Eliminar empresa",
                    text: msg,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willEliminate) => {
                    if (willEliminate) {
                        var url = '/admin/' + company.id + '/eliminarEmpresa';
                        var msg = 'Empresa ' + companyName + ' eliminada correctamente!';
                        axios.get(url).then(response => {
                            this.fetchCompanies();  
                            toastr.success(msg, "Empresa eliminada", {"positionClass": "toast-bottom-right"});
                        });
                    }
                });
            },
            deleteDepartment: function(department) {
                var departmentName = department.name;
                var msg = '¿Borrar el departamento "' + departmentName + '"?';
                swal({
                    title: "Borrar departamento",
                    text: msg,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var url = '/departamentos/recursos/' + department.id;
                        var msg = 'Departamento ' + departmentName + ' borrado correctamente!';
                        axios.delete(url).then(response => {
                            this.fetchDepartments();  
                            toastr.success(msg, "Departamento borrado", {"positionClass": "toast-bottom-right"});
                        });
                    }
                });
            },
            restoreDepartment: function(department) {
                var departmentName = department.name;
                var msg = '¿Restaurar el departamento "' + departmentName + '"?';
                swal({
                    title: "Restaurar departamento",
                    text: msg,
                    icon: "info",
                    buttons: true,
                })
                .then((willRestore) => {
                    if (willRestore) {
                        var url = '/admin/' + department.id + '/restaurarDepartamento';
                        var msg = 'Departamento ' + departmentName + ' restaurado correctamente!';
                        axios.get(url).then(response => {
                            this.fetchDepartments();  
                            toastr.success(msg, "Departamento restaurado", {"positionClass": "toast-bottom-right"});
                        });
                    }
                });
            },
            eliminateDepartment: function(department) {
                var departmentName = department.name;
                var msg = '¿Eliminar el departamento "' + departmentName + '"?';
                swal({
                    title: "Eliminar departamento",
                    text: msg,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willEliminate) => {
                    if (willEliminate) {
                        var url = '/admin/' + department.id + '/eliminarDepartamento';
                        var msg = 'Departamento ' + departmentName + ' eliminado correctamente!';
                        axios.get(url).then(response => {
                            this.fetchDepartments();  
                            toastr.success(msg, "Departamento eliminado", {"positionClass": "toast-bottom-right"});
                        });
                    }
                });
            }
        }
    })

</script>
            
@endsection