@extends('layout')

@section('title', "Empresas")

@section('header')
    <h1 class="mb-3">{{ $title }}</h1>
    {{--Sección de errores--}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <h5>Error en la creación de empresa:</h5>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection

@section('content')

    @if ($companies->isNotEmpty())

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
        <div class="form-group mt-2 mt-md-0 mb-3 row align-items-end">
            <div class="col-10">
                Buscar empresa: <input class="form-controller mr-sm-2" type="text" id="search_companies" name="search_companies" placeholder="Buscar..." aria-label="Search">
            </div>
            @hasrole('Administrador')
                <div class="col-2" id="crear_empresa">
                    <button type="button" class="btn btn-primary" @click="showModel = true" >
                        Crear empresa
                    </button>
                    <model v-if="showModel" @close="showModel = false"></model>
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
        <tbody id="listado_empresas">
        
        </tbody>
    </table>
    @else
        <p>No hay empresas registradas</p>
    @endif

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script>
        Vue.component('model', {
          template: `<!-- The Modal -->
                  <div class="modal" id="createCompanyModal" style="display: block;">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Crear empresa</h4>
                            <button type="button" @click="$emit('close')" class="close"><span>&times;</span></button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <slot>
                            {{--Sección de formulario--}}        
                            <form method="POST" id="crtCompForm" action="{{ route('companies.index') }}">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="name">Nombre:</label>
                                    <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder="Nombre de empresa..." value="{{ old('name') }}">
                                    <small id="nameHelp" class="form-text text-muted">Por ejemplo: Digital Art & Designers</small>
                                </div>

                                <div class="form-group">
                                    <label for="address">Dirección:</label>
                                    <input type="text" class="form-control" name="address" id="address" aria-describedby="addressHelp" placeholder="Pon tu correo aquí..." value="{{ old('address') }}">
                                    <small id="addressHelp" class="form-text text-muted">Por ejemplo: Agustín Millares Carló, 18. Las Palmas, España</small>
                                </div>

                                <div class="form-group">
                                    <label for="description">Descripción:</label><br>
                                    <textarea rows="4" cols="50" class="form-control" name="description" id="description" form="crtCompForm" aria-describedby="descriptionHelp">
                                    {{ old('description') }}
                                    </textarea>
                                    <small id="descriptionHelp" class="form-text text-muted">Mínimo: 20 caracteres</small>
                                </div>

                                <div class="form-group">
                                    <label for="contact">Contacto:</label>
                                    <input type="tel" class="form-control" name="contact" id="contact" aria-describedby="contactHelp" pattern="[0-9]{3} [0-9]{2} [0-9]{2} [0-9]{2}" value="{{ old('contact') }}">
                                    <small id="contactHelp" class="form-text text-muted">Formato: 123 45 67 89</small>
                                </div>

                                <button type="submit" class="btn btn-success">Crear empresa</button>
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

        new Vue({ el: '#crear_empresa',
          data:{
            showModel:false    
          }
        })
</script>

@endsection

