@extends('layout')

@section('title', "Editar departamento")

@section('content')
    <h1>Editar departamento: {{ $department->name }}</h1>


    {{--Sección de errores--}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <h5>Error en la edición de departamento:</h5>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{--Sección de formulario--}}        
    <form method="POST" action="{{ route('departments.show', $department->id) }}">
        {{ method_field('PUT') }}
        {{ csrf_field() }}

        <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder="Nombre de departamento..." value="{{ $department->name }}">
            <small id="nameHelp" class="form-text text-muted">Por ejemplo: Desarrollo</small>
        </div>

        <div class="form-group">
            <label for="address">Director:</label>
            <input type="text" class="form-control" name="director" id="director" aria-describedby="directorHelp" placeholder="Nombre del director..." value="{{ $department->director }}">
            <small id="directorHelp" class="form-text text-muted">Por ejemplo: Pepe Mel</small>
        </div>

        <div class="form-group">
            <label>Tipo de director:</label>
            <fieldset id="director_type">
                <label>
                    <input type="radio" value="En propiedad" name="director_type" {{ ($department->director_type=="En propiedad")? "checked" : "" }}> En propiedad
                </label>
                <br>
                <label>
                    <input type="radio" value="En funciones" name="director_type" {{ ($department->director_type=="En funciones")? "checked" : "" }}> En funciones 
                </label>
            </fieldset>
        </div>

        <div class="form-group">
            <label>Empresa:</label>
            <fieldset id="company_id">
                <label>
                    <input type="radio" value="Sin empresa" name="company_id" {{ ($department->company_id==null)? "checked" : "" }}> Sin empresa
                </label>
                <br> 
                @foreach($companies as $company)
                    <label>
                        <input type="radio" value="{{ $company->name }}" name="company_id" {{ ($department->company_id==$company->id)? "checked" : "" }}> {{ $company->name }}
                    </label>
                    <br> 
                @endforeach
            </fieldset>
        </div>

        <div class="form-group">
            <label for="budget">Presupuesto:</label>
            <input type="number" class="form-control" name="budget" id="budget" aria-describedby="budgetHelp" value="{{ $department->budget }}">
            <small id="budgetHelp" class="form-text text-muted">Introduce el presupuesto (entre 10.000 y 100.000)</small>
        </div>

        <button type="submit" class="btn btn-success">Actualizar departamento</button>
        <a href="{{ route('departments.index') }}" class="btn btn-outline-primary">Regresar a listado de departamentos</a>
    </form>

@endsection

