@extends('layout')

@section('title', "Usuarios")

@section('content')
    <h1 class="mb-3">{{ $title }}</h1>

    @if ($users->isNotEmpty())

    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nombre</th>
            <th scope="col">Correo</th>
            <th scope="col">Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
        <tr>
            <th scope="row">{{ $user->id }}</th>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <form action="{{ route('users.destroy', [$user->id]) }}" method="POST">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <a href="{{ route('users.show', [$user->id]) }}" class="btn btn-info"><span class="oi oi-eye"></span></a> 
                    <a href="{{ route('users.edit', [$user->id]) }}" class="btn btn-primary"><span class="oi oi-pencil"></span></a> 
                    <button type="submit" class="btn btn-danger"><span class="oi oi-trash"></span></button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @else
        <p>No hay usuarios registrados</p>
    @endif

@endsection

@section('search')
    <h1 class="mb-3">Buscar usuarios</h1>

    <form class="form-inline mt-2 mt-md-0 mb-3">
        <input class="form-control mr-sm-2" type="text" placeholder="Búsqueda no disponible!" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
    </form>
    
@endsection

@section('create_user')
    <h1>Crear nuevo usuario</h1>

    <a href="{{ route('users.create') }}" class="btn btn-primary">Nuevo usuario</a>
    

@endsection

