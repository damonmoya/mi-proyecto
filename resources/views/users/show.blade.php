@extends('layout')

@section('title', "Usuario {$user->id}")

@section('content')
    <h1>Usuario #{{ $user->id }}</h1>
            
    <p>Nombre del usuario: {{ $user->name }}</p>
    <p>Correo del usuario: {{ $user->email }}</p>

    <p>
        <a href="{{ route('users.edit', ['id' => $user->id]) }}">Modificar usuario</a>
    </p>

    <p>
        <a href="{{ url('/usuarios') }}">Regresar a listado de usuarios</a>
    </p>

@endsection



