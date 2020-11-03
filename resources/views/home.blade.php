@extends('layout')

@section('title', "Página principal")

@section('content')
    <div class="row">
        <div class="col">
            <h1>Página principal</h1>
        </div>
    </div>
  <div class="row">
    <div class="col">
        <h3>¡Bienvenido, visitante!</h3>
        <a href="{{ url('/usuarios') }}" class="btn btn-outline-primary">Ir a Listado de usuarios</a>
    </div>
  </div>
            
@endsection