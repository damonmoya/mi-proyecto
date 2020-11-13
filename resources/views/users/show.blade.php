@extends('layout')

@section('title', "Usuario {$user->id}")

@section('header')
    @if ($email_sent)
        <div class="alert alert-success" role="alert">
            ¡Correo con pdf ajunto enviado!
        </div>
    @endif
    <div class="form-group mt-2 mt-md-0 mb-3 row align-items-end">
        <div class="col-10">
            <h1>Usuario #{{ $user->id }} ({{ $user->name }})</h1>
        </div>
        <div class="col-2">
            <a class="btn btn-primary noprint" href="{{route('users.show', ['id' => $user->id, 'download'=>'pdf'])}}">Enviar correo con PDF</a>
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

    @can('Editar usuarios')
        <p>
            <a href="{{ route('users.edit', [$user->id]) }}" class="btn btn-primary">Editar usuario</a> 
        </p>
    @endcan
    <p>
        <a href="{{ route('users.index') }} " class="btn btn-outline-primary">Regresar a listado de usuarios</a>
    </p>
        
@endsection



