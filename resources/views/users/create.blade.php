@extends('layout')

@section('title', "Crear usuario")

@section('content')
    <h1>Crear usuario</h1>


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
    <form method="POST" action="{{ url('/usuarios') }}">
        {{ csrf_field() }}

        <label for="name">Nombre:</label><br>
        <input type="text" name="name" id="name" placeholder="p.e: Kike Pérez" value="{{ old('name') }}"><br>

        <label for="email">Correo:</label><br>
        <input type="email" name="email" id="email" placeholder="p.e: kikeperez@hotmail.es" value="{{ old('email') }}"><br>

        <label for="password">Clave:</label><br>
        <input type="password" name="password" id="password"><br>

        <label for="confirm_password">Confirmar clave:</label><br>
        <input type="password" name="confirm_password" id="confirm_password"><br><br>

        <button type="submit">Crear usuario</button><br><br>
    </form>

    <p>
        <a href="{{ url('/usuarios') }}">Regresar a listado de usuarios</a>
    </p>

@endsection



