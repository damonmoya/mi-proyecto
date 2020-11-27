@extends('layout')

@section('title', "Profesiones")

@section('header')
    <h1 class="mb-3">{{ $title }}</h1>
@endsection

@section('content')

    <div id="control_profesion">

        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <div class="form-group mt-2 mt-md-0 mb-3 row">
                    <div class="col-10">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text" id="btnGroupAddon2"><span class="oi oi-magnifying-glass"></span></div>
                            </div>
                        <input class="form-control py-2 border-right-0 border" v-model="keywords" type="search" placeholder="Buscar profesion">
                    </div>
                </div>
                @hasrole('Administrador')
                    <div class="col-2">
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#createProfessionModal">Crear profesión</a>
                    </div>
                @endhasrole
            </div>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Acciones</th>
            </tr>
            </thead>
            <tbody v-if="professions.length > 0">
                <tr v-for="profession in professions" :key="profession.id">
                    <td> @{{ profession.id }} </td>
                    <td> @{{ profession.title }} </td>
                    <td>
                        <a :href="'/profesiones/' + profession.id" class='btn btn-info'><span class='oi oi-eye'></span></a>
                        @hasrole('Administrador')
                            <a href='#' class='btn btn-primary' v-on:click.prevent="editProfession(profession)"><span class='oi oi-pencil'></span></a> 
                            <a href='#' class='btn btn-danger' v-on:click.prevent="deleteProfession(profession)"><span class='oi oi-trash'></span></a>
                        @endhasrole
                    </td>
                </tr>
            </tbody>
        </table>

        @include('professions.create')
        @include('professions.edit')

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
            el: '#control_profesion',
            created: function() {
                this.getProfessions();
            },
            data: {
                keywords: null,
                professions: [],
                newProfessionTitle: '',
                fillProfession: {'id': '', 'title': ''},
                errors: new Errors()
            },
            watch: {
                keywords(after, before) {
                    this.fetch();
                }
            },
            methods: {
                fetch() {
                    axios.get('/profesiones/search', { params: { keywords: this.keywords } })
                        .then(response => this.professions = response.data)
                        .catch(error => {});
                },
                clearErrors: function(){
                    this.errors.reset();
                },
                getProfessions: function(){
                    var urlProfession = '/profesiones/recursos';
                    axios.get(urlProfession).then(response => {
                        this.professions = response.data
                    });
                },
                editProfession: function(profession) {
                    this.fillProfession.id = profession.id;
                    this.fillProfession.title = profession.title;
                    $('#editProfessionModal').modal('show');
                },
                updateProfession: function(id) {
                    var url = '/profesiones/recursos/' + id;
                    axios.put(url, {
                        title: this.fillProfession.title
                    }).then(response => {
                        this.getProfessions();
                        var msg = '¡Se ha editado la profesión ' + this.fillProfession.title + ' correctamente!';
                        toastr.success(msg, "Profesión modificada", {"positionClass": "toast-bottom-right"});
                        this.fillProfession = {'id': '', 'title': ''};
                        this.errors.reset();
                        $('#editProfessionModal').modal('hide');
                    }).catch(error => {
                        this.errors.record(error.response.data.errors);
                        toastr.error("No se ha podido actualizar la profesión, por favor revisa los errores", "Error al editar profesión", {"positionClass": "toast-bottom-right"});
                    });
                },
                deleteProfession: function(profession) {
                    var url = '/profesiones/recursos/' + profession.id;
                    var professionTitle = profession.title;
                    var msg = 'Profesión ' + professionTitle + ' eliminada correctamente!';
                    axios.delete(url).then(response => {
                        this.getProfessions();  
                        toastr.success(msg, "Profesión eliminada", {"positionClass": "toast-bottom-right"});
                    });
                },
                createProfession: function() {
                    var url = '/profesiones/recursos';
                    axios.post(url, {
                        title: this.newProfessionTitle
                    }).then(response => {
                        this.getProfessions();
                        var msg = '¡Se ha creado la profesión ' + this.newProfessionTitle + ' correctamente!';
                        toastr.success(msg, "Profesión creada", {"positionClass": "toast-bottom-right"});
                        this.title = '';
                        this.errors.reset();
                        $('#createProfessionModal').modal('hide');
                    }).catch(error => {
                        this.errors.record(error.response.data.errors);
                        toastr.error("No se ha podido crear la profesión, por favor revisa los errores", "Error al crear profesión", {"positionClass": "toast-bottom-right"});
                    });
                }
            }
        })

    </script>

@endsection