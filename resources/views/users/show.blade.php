@extends('layout')

@section('title', "Usuario {$user->id}")

@section('content')
    <h1>Usuario #{{ $user->id }}</h1>
            
    <p>Nombre del usuario: {{ $user->name }}</p>
    <p>Correo del usuario: {{ $user->email }}</p>

    <p>
        <a href="{{ route('users.edit', ['id' => $user->id]) }}" class="btn btn-primary">Modificar usuario</a>
    </p>

    <form action="{{ route('users.destroy', [$user->id]) }}" method="POST">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
        <button type="submit" class="btn btn-danger">Eliminar usuario</button>
    </form>

    <br><br>

    <a href="{{ url('/usuarios') }} " class="btn btn-outline-primary">Regresar a listado de usuarios</a>

@endsection



