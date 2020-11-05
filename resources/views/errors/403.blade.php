@extends('layout')

@section('title', "Acceso restringido")

@section('content')
    <h1>Acceso restringido</h1>
    <p>
        <a href="{{ route('home') }}" class="btn btn-outline-primary">Regresar a la página principal</a>
    </p>       
    

@endsection