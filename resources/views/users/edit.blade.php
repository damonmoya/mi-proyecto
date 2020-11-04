@if (auth()->check())
    <?php
        $loggedUser = auth()->user();
    ?>
    @if ($loggedUser->is_admin == false)
        <script>window.location.href = "{{ route('home') }}";</script>
    @endif
@endif

@extends('layout')

@section('title', "Editar usuario")

@section('content')
    <h1>Editar usuario: #{{ $user->id }}</h1>


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
        <a href="{{ route('users.index') }}" class="btn btn-outline-primary">Regresar a listado de usuarios</a>
    </form>

@endsection

