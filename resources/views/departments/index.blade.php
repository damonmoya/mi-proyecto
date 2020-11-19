@extends('layout')

@section('title', "Departamentos")

@section('header')
    <h1 class="mb-3">{{ $title }}</h1>
    {{--Sección de errores--}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <h5>Error en la creación de departamento:</h5>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection

@section('content')

    @if ($departments->isNotEmpty())

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
        <div class="form-group mt-2 mt-md-0 mb-3 row align-items-end">
            <div class="col-10">
                Buscar departamento: <input class="form-controller mr-sm-2" type="text" id="search_departments" name="search_departments" placeholder="Buscar..." aria-label="Search">
            </div>
            @hasrole('Administrador')
                <div class="col-2" id="crear_departamento">
                    <button type="button" class="btn btn-primary" @click="showCreateModel = true" >
                        Crear departamento
                    </button>
                    <model v-if="showCreateModel" @close="showCreateModel = false"></model>
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
        <tbody id="listado_departamentos">
        
        </tbody>
    </table>
    @else
        <p>No hay departamentos registradas</p>
    @endif

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script>
        Vue.component('model', {
          template: `<!-- The Modal -->
                  <div class="modal" id="createUserModal" style="display: block;">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Crear usuario</h4>
                            <button type="button" @click="$emit('close')" class="close"><span>&times;</span></button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <slot>
                                {{--Sección de formulario--}}        
                                <form method="POST" action="{{ route('departments.index') }}">
                                    {{ csrf_field() }}

                                    <div class="form-group">
                                        <label for="name">Nombre:</label>
                                        <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder="Nombre de departamento..." value="{{ old('name') }}">
                                        <small id="nameHelp" class="form-text text-muted">Por ejemplo: Desarrollo</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="address">Director:</label>
                                        <input type="text" class="form-control" name="director" id="director" aria-describedby="directorHelp" placeholder="Nombre del director..." value="{{ old('director') }}">
                                        <small id="directorHelp" class="form-text text-muted">Por ejemplo: Pepe Mel</small>
                                    </div>

                                    <div class="form-group">
                                        <label>Tipo de director:</label>
                                        <fieldset id="director_type">
                                            <label>
                                                <input type="radio" value="En propiedad" name="director_type" checked> En propiedad
                                            </label>
                                            <br>
                                            <label>
                                                <input type="radio" value="En funciones" name="director_type"> En funciones 
                                            </label>
                                        </fieldset>
                                    </div>

                                    <div class="form-group">
                                        <label>Empresa:</label>
                                        <fieldset id="company">
                                            <label>
                                                <input type="radio" value="Sin empresa" name="company" checked> Sin empresa
                                            </label>
                                            <br> 
                                            @foreach($companies as $company)
                                                <label>
                                                    <input type="radio" value="{{ $company->name }}" name="company"> {{ $company->name }}
                                                </label>
                                                <br> 
                                            @endforeach

                                           {{-- <company_depts :="{{ $companies->replies }}"></company_depts> --}} 
                                        </fieldset>
                                    </div>

                                    <div class="form-group">
                                        <label for="budget">Presupuesto:</label>
                                        <input type="number" class="form-control" name="budget" id="budget" aria-describedby="budgetHelp" value="10000">
                                        <small id="budgetHelp" class="form-text text-muted">Introduce el presupuesto (entre 10.000 y 100.000)</small>
                                    </div>

                                    <button type="submit" class="btn btn-success">Crear empresa</button>
                                    <a href="{{ route('departments.index') }}" class="btn btn-outline-primary">Regresar a listado de departamentos</a>
                                </form>
                            </slot>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                          <button type="button" @click="$emit('close')" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        </div>
                      </div>
                    </div>
                  </div>
                    `
        });

        new Vue({ el: '#crear_departamento',
          data:{
            showCreateModel:false
          }
        })

    </script>

@endsection

