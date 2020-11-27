@extends('layout')

@section('title', "Empresas")

@section('header')
    <h1 class="mb-3">{{ $title }}</h1>
@endsection

@section('content')

    <div id="control_empresa">

        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <div class="form-group mt-2 mt-md-0 mb-3 row">
                    <div class="col-10">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text" id="btnGroupAddon2"><span class="oi oi-magnifying-glass"></span></div>
                            </div>
                        <input class="form-control py-2 border-right-0 border" v-model="keywords" type="search" placeholder="Buscar empresa">
                    </div>
                </div>
                @hasrole('Administrador')
                    <div class="col-2">
                        <a href="#" class="btn btn-primary pull-right" data-toggle="modal" data-target="#createCompanyModal">Crear empresa</a>
                    </div>
                @endhasrole
            </div>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Descripción</th>
                <th scope="col">Acciones</th>
            </tr>
            </thead>
            <tbody v-if="companies.length > 0">
                <tr v-for="company in companies" :key="company.id">
                    <td> @{{ company.id }} </td>
                    <td> @{{ company.name }} </td>
                    <td> @{{ company.description }} </td>
                    <td>
                        <a :href="'/empresas/' + company.id" class='btn btn-info'><span class='oi oi-eye'></span></a>
                        @hasrole('Administrador')
                            <a href='#' class='btn btn-primary' v-on:click.prevent="editCompany(company)"><span class='oi oi-pencil'></span></a> 
                            <a href='#' class='btn btn-danger' v-on:click.prevent="deleteCompany(company)"><span class='oi oi-trash'></span></a>
                        @endhasrole
                    </td>
                </tr>
            </tbody>
        </table>
        
        @include('companies.create')
        @include('companies.edit')

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
            el: '#control_empresa',
            created: function() {
                this.getCompanies();
            },
            data: {
                keywords: null,
                companies: [],
                newCompanyName: '',
                newCompanyAddress: '',
                newCompanyDescription: '',
                newCompanyContact: '',
                fillCompany: {'id': '', 'name': '', 'address': '', 'description': '', 'contact': ''},
                errors: new Errors()
            },
            watch: {
                keywords(after, before) {
                    this.fetch();
                }
            },
            methods: {
                fetch() {
                    axios.get('/empresas/search', { params: { keywords: this.keywords } })
                        .then(response => this.companies = response.data)
                        .catch(error => {});
                },
                clearErrors: function(){
                    this.errors.reset();
                },
                getCompanies: function(){
                    var urlCompanies = '/empresas/recursos';
                    axios.get(urlCompanies).then(response => {
                        this.companies = response.data
                    });
                },
                editCompany: function(company) {
                    this.fillCompany.id = company.id;
                    this.fillCompany.name = company.name;
                    this.fillCompany.address = company.address;
                    this.fillCompany.description = company.description;
                    this.fillCompany.contact = company.contact;
                    $('#editCompanyModal').modal('show');
                },
                updateCompany: function(id) {
                    var url = '/empresas/recursos/' + id;
                    axios.put(url, {
                        name: this.fillCompany.name,
                        address: this.fillCompany.address,
                        description: this.fillCompany.description,
                        contact: this.fillCompany.contact
                    }).then(response => {
                        this.getCompanies();
                        var msg = '¡Se ha editado la empresa ' + this.fillCompany.name + ' correctamente!';
                        toastr.success(msg, "Empresa modificada", {"positionClass": "toast-bottom-right"});
                        this.fillCompany = {'id': '', 'name': '', 'address': '', 'description': '', 'contact': ''};
                        this.errors.reset();
                        $('#editCompanyModal').modal('hide');
                    }).catch(error => {
                        this.errors.record(error.response.data.errors);
                        toastr.error("No se ha podido actualizar la empresa, por favor revisa los errores", "Error al editar empresa", {"positionClass": "toast-bottom-right"});

                    });
                },
                deleteCompany: function(company) {
                    var url = '/empresas/recursos/' + company.id;
                    var companyName = company.name;
                    var msg = 'Empresa ' + companyName + ' eliminada correctamente!';
                    axios.delete(url).then(response => {
                        this.getCompanies();  
                        toastr.success(msg, "Empresa eliminada", {"positionClass": "toast-bottom-right"});
                    });
                },
                createCompany: function() {
                    var url = '/empresas/recursos';
                    axios.post(url, {
                        name: this.newCompanyName,
                        address: this.newCompanyAddress,
                        description: this.newCompanyDescription,
                        contact: this.newCompanyContact
                    }).then(response => {
                        this.getCompanies();
                        var msg = '¡Se ha creado la empresa ' + this.newCompanyName + ' correctamente!';
                        toastr.success(msg, "Empresa creada", {"positionClass": "toast-bottom-right"});
                        this.name = '';
                        this.address = '';
                        this.description = '';
                        this.contact = '';
                        this.errors.reset();
                        $('#createCompanyModal').modal('hide');
                    }).catch(error => {
                        this.errors.record(error.response.data.errors);
                        toastr.error("No se ha podido crear la empresa, por favor revisa los errores", "Error al crear empresa", {"positionClass": "toast-bottom-right"});
                    });
                }
            }
        })

</script>

@endsection

