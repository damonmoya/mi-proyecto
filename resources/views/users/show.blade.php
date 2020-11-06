@extends('layout')

@section('title', "Usuario {$user->id}")

@section('header')
    <h1>Usuario #{{ $user->id }} ({{ $user->name }})</h1>
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
    
    @can('Editar usuarios')
        <p>
            <a href="{{ route('users.edit', [$user->id]) }}" class="btn btn-primary">Editar usuario</a> 
        </p>
    @endcan
    
    <p>
        <a href="{{ route('users.index') }} " class="btn btn-outline-primary">Regresar a listado de usuarios</a>
    </p>
@endsection



