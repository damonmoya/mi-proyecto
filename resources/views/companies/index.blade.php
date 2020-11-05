@extends('layout')

@section('title', "Empresa")

@section('header')
    <h1 class="mb-3">{{ $title }}</h1>
@endsection

@section('content')

    @if ($companies->isNotEmpty())

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
        <div class="form-group mt-2 mt-md-0 mb-3 row align-items-end">
            <div class="col-10">
                Buscar Empresa: <input class="form-controller mr-sm-2" type="text" id="search_companies" name="search_companies" placeholder="Buscar..." aria-label="Search">
            </div>
        </div>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nombre</th>
            <th scope="col">Descripción</th>
            <th scope="col">Acciones</th>
        </tr>
        </thead>
        <tbody id="listado_empresas">
        
        </tbody>
    </table>
    @else
        <p>No hay empresas registradas</p>
    @endif

@endsection

