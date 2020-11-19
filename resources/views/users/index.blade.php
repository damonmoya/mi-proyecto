@extends('layout')

@section('title', "Usuarios")

@section('header')
    <h1 class="mb-3">{{ $title }}</h1>
    {{--Sección de errores--}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <h5>Error en la creación del usuario:</h5>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection

@section('content')

    @if ($users->isNotEmpty())

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
        <div class="form-group mt-2 mt-md-0 mb-3 row align-items-end">
            <div class="col-10">
                Buscar usuario: <input class="form-controller mr-sm-2" type="text" id="search" name="search" placeholder="Buscar..." aria-label="Search">
            </div>
            @hasrole('Administrador')
                <div class="col-2" id="control_usuario">
                    <button type="button" class="btn btn-primary" @click="showCreateModel = true" >
                        Crear usuario
                    </button>
                    <create-model v-if="showCreateModel" @close="showCreateModel = false"></create-model>
                    <!--<detailModel v-if='showDetailModel' @close='showDetailModel = false'></detailModel>-->
                    <edit-model v-if='showEditModel' @close='showEditModel = false' :user="{{ $user }}"></edit-model>
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
        <tbody id="listado">
        
        </tbody>
    </table>
    @else
        <p>No hay usuarios registrados</p>
    @endif
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script>

        Vue.component('create-model', {
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
                                <form method="POST" action="{{ route('users.index') }}">
                                    {{ csrf_field() }}

                                    <div class="form-group">
                                        <label for="name">Nombre:</label>
                                        <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder="Pon tu nombre aquí..." value="{{ old('name') }}">
                                        <small id="nameHelp" class="form-text text-muted">Por ejemplo: Kike Pérez</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Correo:</label>
                                        <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Pon tu correo aquí..." value="{{ old('email') }}">
                                        <small id="emailHelp" class="form-text text-muted">Por ejemplo: kikeperez@hotmail.es</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Clave:</label>
                                        <input type="password" class="form-control" name="password" id="password" aria-describedby="passwordHelp" placeholder="Pon tu clave aquí...">
                                        <small id="passwordHelp" class="form-text text-muted">Mínimo: 6 caracteres</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="confirm_password">Confirmar clave:</label>
                                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" aria-describedby="confirmpasswordHelp">
                                        <small id="confirmpasswordHelp" class="form-text text-muted">Confirma la clave</small>
                                    </div>

                                    <button type="submit" class="btn btn-success">Crear usuario</button>
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

        Vue.component('edit-model', {
          template: `<!-- The Modal -->
                  <div class="modal" id="editUserModal" style="display: block;">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Editar usuario</h4>
                            <button type="button" @click="$emit('close')" class="close"><span>&times;</span></button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <slot>
                            {{--Sección de formulario--}}        
                            <form method="POST" action="{{ route('users.show', $user->id) }}">
                                {{ method_field('PUT') }}
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="name">Nombre:</label>
                                    <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder="Pon tu nombre aquí..." value="{{ $user->name }}">
                                    <small id="nameHelp" class="form-text text-muted">Por ejemplo: Kike Pérez</small>
                                </div>

                                <div class="form-group">
                                    <label for="email">Correo:</label>
                                    <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Pon tu correo aquí..." value="{{ $user->email }}">
                                    <small id="emailHelp" class="form-text text-muted">Por ejemplo: kikeperez@hotmail.es</small>
                                </div>

                                <div class="form-group">
                                    <label for="password">Clave:</label>
                                    <input type="password" class="form-control" name="password" id="password" aria-describedby="passwordHelp" placeholder="Pon tu clave aquí...">
                                    <small id="passwordHelp" class="form-text text-muted">Mínimo: 6 caracteres. Dejar en blanco si no se desea cambiar</small>
                                </div>

                                <div class="form-group">
                                    <label for="confirm_password">Confirmar clave:</label>
                                    <input type="confirm_password" class="form-control" name="confirm_password" id="confirm_password" aria-describedby="confirmpasswordHelp">
                                    <small id="confirmpasswordHelp" class="form-text text-muted">Confirma la clave, en caso de cambiarla</small>
                                </div>

                                <button type="submit" class="btn btn-success">Actualizar usuario</button>
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

        const app = new Vue({ 
            el: '#control_usuario',
            data:{
                id: null,
                user: null,
                showCreateModel:false,
                showDetailModel:false,
                showEditModel:false 
            }
        })

        //$("[data-id]").on("click", function(){
        //    app.id = this.dataset.id;
        //    const users = @json($users);
        //})

</script>

@endsection