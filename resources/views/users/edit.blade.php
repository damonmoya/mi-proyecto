@extends('layout')

@section('title', "Editar usuario")

@section('content')
    <h1>Editar usuario</h1>


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
    <form method="POST" action="{{ url("/usuarios/{$user->id}") }}">
        {{ method_field('PUT') }}
        {{ csrf_field() }}

        <label for="name">Nombre:</label><br>
        <input type="text" name="name" id="name" placeholder="p.e: Kike Pérez" value="{{ $user->name }}"><br>

        <label for="email">Correo:</label><br>
        <input type="email" name="email" id="email" placeholder="p.e: kikeperez@hotmail.es" value="{{ $user->email }}"><br>

        <label for="password">Clave:</label><br>
        <input type="password" name="password" id="password" placeholder="Opcional..."><br>

        <label for="confirm_password">Confirmar clave:</label><br>
        <input type="password" name="confirm_password" id="confirm_password"><br><br>

        <button type="submit">Actualizar usuario</button><br><br>
    </form>

    <p>
        <a href="{{ url('/usuarios') }}">Regresar a listado de usuarios</a>
    </p>

@endsection



