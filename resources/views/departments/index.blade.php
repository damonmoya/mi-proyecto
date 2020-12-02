@extends('layout')

@section('title', "Departamentos")

@section('header')
    <h1 class="mb-3">{{ $title }}</h1>
@endsection

@section('content')

    <div id="control_departamento">

        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <div class="form-group mt-2 mt-md-0 mb-3 row">
                    <div class="col-10">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text" id="btnGroupAddon2"><span class="oi oi-magnifying-glass"></span></div>
                            </div>
                        <input class="form-control py-2 border-right-0 border" v-model="keywords" type="search" placeholder="Buscar departamento">
                    </div>
                </div>
                @hasrole('Administrador')
                    <div class="col-2">
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#createDepartmentModal">Crear departamento</a>
                    </div>
                @endhasrole
            </div>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Director</th>
                <th scope="col">Acciones</th>
            </tr>
            </thead>
            <tbody v-if="departments.length > 0">
                <tr v-for="department in departments" :key="department.id">
                    <td> @{{ department.id }} </td>
                    <td> @{{ department.name }} </td>
                    <td> @{{ department.director }} </td>
                    <td>
                        <a :href="'/departamentos/' + department.id" class='btn btn-info'><span class='oi oi-eye'></span></a>
                        @hasrole('Administrador')
                            <a href='#' class='btn btn-primary' v-on:click.prevent="editDepartment(department)"><span class='oi oi-pencil'></span></a> 
                            <a href='#' class='btn btn-danger' v-on:click.prevent="deleteDepartment(department)"><span class='oi oi-trash'></span></a>
                        @endhasrole
                    </td>
                </tr>
            </tbody>
        </table>

        @include('departments.create')
        @include('departments.edit')

    </div>

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
            el: '#control_departamento',
            created: function() {
                this.getDepartments();
                this.getCompanies();
            },
            data: {
                keywords: null,
                departments: [],
                companies: [],
                dependents: [],
                newDepartmentName: '',
                newDepartmentDirector: '',
                newDepartmentDirector_type: '',
                newDepartmentCompany: '',
                newDepartmentDependent: '',
                newDepartmentBudget: '',
                fillDepartment: {'id': '', 'name': '', 'director': '', 'director_type': '', 'company_id': '', 'dependent_id': '', 'budget': ''},
                errors: new Errors()
            },
            watch: {
                keywords(after, before) {
                    this.fetch();
                }
            },
            methods: {
                fetch() {
                    axios.get('/departamentos/search', { params: { keywords: this.keywords } })
                        .then(response => this.departments = response.data)
                        .catch(error => {});
                },
                clearErrors: function(){
                    this.errors.reset();
                },
                getDepartments: function(){
                    var urlDepartment = '/departamentos/recursos';
                    axios.get(urlDepartment).then(response => {
                        this.departments = response.data
                    });
                },
                editDepartment: function(department) {
                    this.fillDepartment.id = department.id;
                    this.fillDepartment.name = department.name;
                    this.fillDepartment.director = department.director;
                    this.fillDepartment.director_type = department.director_type;
                    this.fillDepartment.company_id = department.company_id;
                    if (department.dependent_id == null){
                        this.fillDepartment.dependent_id = 'no';
                    } else {
                        this.fillDepartment.dependent_id = department.dependent_id;
                    }
                    this.fillDepartment.budget = department.budget;
                    this.onEdit(department.company_id);
                    $('#editDepartmentModal').modal('show');
                },
                updateDepartment: function(id) {
                    var url = '/departamentos/recursos/' + id;
                    axios.put(url, {
                        name: this.fillDepartment.name,
                        director: this.fillDepartment.director,
                        director_type: this.fillDepartment.director_type,
                        company_id: this.fillDepartment.company_id,
                        dependent_id: this.fillDepartment.dependent_id,
                        budget: this.fillDepartment.budget
                    }).then(response => {
                        this.getDepartments();
                        var msg = '¡Se ha editado el departamento ' + this.fillDepartment.name + ' correctamente!';
                        toastr.success(msg, "Departamento modificado", {"positionClass": "toast-bottom-right"});
                        this.fillDepartment = {'id': '', 'name': '', 'director': '', 'director_type': '', 'company_id': '', 'dependent_id': '', 'budget': ''};
                        this.errors.reset();
                        $('#editDepartmentModal').modal('hide');
                    }).catch(error => {
                        this.errors.record(error.response.data.errors);
                        toastr.error("No se ha podido actualizar el departamento, por favor revisa los errores", "Error al editar departamento", {"positionClass": "toast-bottom-right"});

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
                            var msg = '¡Departamento ' + departmentName + ' eliminado correctamente!';
                            axios.delete(url).then(response => {
                                this.getDepartments();  
                                toastr.success(msg, "Departamento eliminado", {"positionClass": "toast-bottom-right"});
                            });
                        }
                    });
                },
                createDepartment: function() {
                    var url = '/departamentos/recursos';
                    axios.post(url, {
                        name: this.newDepartmentName,
                        director: this.newDepartmentDirector,
                        director_type: this.newDepartmentDirector_type,
                        company_id: this.newDepartmentCompany,
                        dependent_id: this.newDepartmentDependent,
                        budget: this.newDepartmentBudget
                    }).then(response => {
                        this.getDepartments();
                        var msg = '¡Se ha creado el departamento ' + this.newDepartmentName + ' correctamente!';
                        toastr.success(msg, "Departamento creado", {"positionClass": "toast-bottom-right"});
                        this.name = '';
                        this.director = '';
                        this.director_type = '';
                        this.company_id = '';
                        this.dependent_id = '';
                        this.budget = '';
                        this.errors.reset();
                        $('#createDepartmentModal').modal('hide');
                    }).catch(error => {
                        this.errors.record(error.response.data.errors);
                        toastr.error("No se ha podido crear el departamento, por favor revisa los errores", "Error al crear departamento", {"positionClass": "toast-bottom-right"});

                    });
                },
                onChange(event) {
                    this.newDepartmentDependent= '';
                    this.fillDepartment.dependent_id= '';
                    axios.get('/empresas/dependents', { params: { company: event.target.value } })
                        .then(response => this.dependents = response.data)
                        .catch(error => {});
                },
                onEdit(id) {
                    //this.newDepartmentDependent= '';
                    axios.get('/empresas/dependents', { params: { company: id} })
                        .then(response => this.dependents = response.data)
                        .catch(error => {});
                    this.getCompanies();
                },
                getCompanies: function(){
                    var urlCompanies = '/empresas/recursos';
                    axios.get(urlCompanies).then(response => {
                        this.companies = response.data
                    });
                }
            }
        })

    </script>

@endsection

