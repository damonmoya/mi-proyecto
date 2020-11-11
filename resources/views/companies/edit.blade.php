@extends('layout')

@section('title', "Editar empresa")

@section('content')
    <h1>Editar empresa: {{ $company->name }}</h1>


    {{--Sección de errores--}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <h5>Error en la edición de empresa:</h5>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{--Sección de formulario--}}        
    <form method="POST" id="crtCompForm" action="{{ route('companies.show', $company->id) }}">
        {{ method_field('PUT') }}
        {{ csrf_field() }}

        <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder="Nombre de empresa..." value="{{ $company->name }}">
            <small id="nameHelp" class="form-text text-muted">Por ejemplo: Digital Art & Designers</small>
        </div>

        <div class="form-group">
            <label for="address">Dirección:</label>
            <input type="text" class="form-control" name="address" id="address" aria-describedby="addressHelp" placeholder="Pon tu correo aquí..." value="{{ $company->address }}">
            <small id="addressHelp" class="form-text text-muted">Por ejemplo: Agustín Millares Carló, 18. Las Palmas, España</small>
        </div>

        <div class="form-group">
            <label for="description">Descripción:</label><br>
            <textarea rows="4" cols="50" class="form-control" name="description" id="description" form="crtCompForm" aria-describedby="descriptionHelp">
            {{ $company->description }}
            </textarea>
            <small id="descriptionHelp" class="form-text text-muted">Mínimo: 20 caracteres</small>
        </div>

        <div class="form-group">
            <label for="contact">Contacto:</label>
            <input type="tel" class="form-control" name="contact" id="contact" aria-describedby="contactHelp" pattern="[0-9]{3} [0-9]{2} [0-9]{2} [0-9]{2}" value="{{ $company->contact }}">
            <small id="contactHelp" class="form-text text-muted">Formato: 123 45 67 89</small>
        </div>

        <button type="submit" class="btn btn-success">Actualizar empresa</button>
        <a href="{{ route('companies.index') }}" class="btn btn-outline-primary">Regresar a listado de empresas</a>
    </form>

@endsection



