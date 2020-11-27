@extends('layout')

@section('title', "Usuario {$user->id}")

@section('header')
    <div class="form-group mt-2 mt-md-0 mb-3 row align-items-end">
        <div class="col-10">
            <h1>Usuario #{{ $user->id }} ({{ $user->name }})</h1>
        </div>
        <div class="col-2" id="enviar_pdf">
            <a href='#' class="btn btn-primary" v-on:click.prevent="send_email_pdf">Enviar correo con PDF</a>
        </div>
    </div>
@endsection

@section('content')
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Correo</th>
            <th scope="col">Profesión</th>
            <th scope="col">Departamento</th>
            <th scope="col">Departamento dependiente</th>
            <th scope="col">Empresa</th>
            <th scope="col">Tipo Usuario</th>
            <th scope="col">Creado en</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $oficio }}</td>
            <td>{{ $departamento_usuario }}</td>
            <td>{{ $departamento_dependiente }}</td>
            <td>{{ $empresa }}</td>
            <td>{{ $tipo_usuario }}</td>
            <td>{{ $user->created_at }}</td>
        </tr>
        </tbody>
    </table>

    <p>
        <a href="{{ route('users.index') }} " class="btn btn-outline-primary">Regresar a listado de usuarios</a>
    </p>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        const app = new Vue({ 
            el: '#enviar_pdf',
            data: {
                user: @json($user)
            },
            methods: {
                send_email_pdf() {
                    var msg = 'Generando PDF con detalle del usuario ' + this.user.name + '...';
                    toastr.info(msg, "Info", {"positionClass": "toast-bottom-right"});
                    axios.get('/usuarios/send_email', { params: { id: this.user.id } })
                            .then(response => {
                                var msg = '¡Se ha enviado el pdf a tu correo (' + response.data + ')!';
                                toastr.success(msg, "Correo enviado", {"positionClass": "toast-bottom-right"});  
                            }).catch(error => {});
                }
            }
        })
    </script>
        
@endsection