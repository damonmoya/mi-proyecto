@extends('layout')

@section('title', "Crear usuario")

@section('content')
    <h1>Crear usuario</h1>
            
    <form method="POST" action="{{ url('/usuarios') }}">
        {{ csrf_field() }}

        <label for="name">Nombre:</label><br>
        <input type="text" name="name" id="name" placeholder="p.e: Kike Pérez"><br>

        <label for="email">Email:</label><br>
        <input type="email" name="email" id="email" placeholder="p.e: kikeperez@hotmail.es"><br>

        <label for="password">Clave:</label><br>
        <input type="password" name="password" id="password" placeholder="p.e: elmejorcomediante"><br><br>

        <button type="submit">Crear usuario</button><br><br>
    </form>

    <p>
        <a href="{{ url('/usuarios') }}">Regresar a listado de usuarios</a>
    </p>

@endsection



