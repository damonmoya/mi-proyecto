@extends('layout')

@section('title', "Departamentos")

@section('header')
    <h1 class="mb-3">{{ $title }}</h1>
@endsection

@section('content')

    @if ($companies->isNotEmpty())

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
        <div class="form-group mt-2 mt-md-0 mb-3 row align-items-end">
            <div class="col-10">
                Buscar departamento: <input class="form-controller mr-sm-2" type="text" id="search_departments" name="search_departments" placeholder="Buscar..." aria-label="Search">
            </div>
            @hasrole('Administrador')
                <div class="col-2">
                    <a href="{{ route('departments.create') }}" class="btn btn-primary">Nuevo departamento</a>
                </div>
            @endhasrole
        </div>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nombre</th>
            <th scope="col">Director</th>
            <th scope="col">Acciones</th>
        </tr>
        </thead>
        <tbody id="listado_departamentos">
        
        </tbody>
    </table>
    @else
        <p>No hay departamentos registradas</p>
    @endif

@endsection

