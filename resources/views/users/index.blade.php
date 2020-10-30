@extends('layout')

@section('title', "Usuarios")

@section('header')
    <h1 class="mb-3">{{ $title }}</h1>
@endsection

@section('content')

    @if ($users->isNotEmpty())

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
        <div class="form-group mt-2 mt-md-0 mb-3 row align-items-end">
            <div class="col-10">
                Buscar usuario: <input class="form-controller mr-sm-2" type="text" id="search" name="search" placeholder="Buscar..." aria-label="Search">
            </div>
            <div class="col-2">
                <a href="{{ route('users.create') }}" class="btn btn-primary">Nuevo usuario</a>
            </div>
        </div>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nombre</th>
            <th scope="col">Correo</th>
            <th scope="col">Acciones</th>
        </tr>
        </thead>
        <tbody id="listado">
        
        </tbody>
    </table>
    @else
        <p>No hay usuarios registrados</p>
    @endif

@endsection

