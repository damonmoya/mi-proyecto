@extends('layout')

@section('title', "Página no encontrada")

@section('content')
    <h1>Página no encontrada</h1>
    <p>
        <a href="{{ route('home') }}" class="btn btn-outline-primary">Regresar a la página principal</a>
    </p>       
    

@endsection



