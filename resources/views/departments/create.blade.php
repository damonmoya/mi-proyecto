@extends('layout')

@section('title', "Crear departamento")

@section('content')
    <h1>Crear departamento</h1>


    {{--Sección de errores--}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <h5>Error en la creación de departamentos:</h5>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{--Sección de formulario--}}        
    <form method="POST" action="{{ route('departments.index') }}">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder="Nombre de departamento..." value="{{ old('name') }}">
            <small id="nameHelp" class="form-text text-muted">Por ejemplo: Desarrollo</small>
        </div>

        <div class="form-group">
            <label for="address">Director:</label>
            <input type="text" class="form-control" name="director" id="director" aria-describedby="directorHelp" placeholder="Nombre del director..." value="{{ old('director') }}">
            <small id="directorHelp" class="form-text text-muted">Por ejemplo: Pepe Mel</small>
        </div>

        <div class="form-group">
            <label>Tipo de director:</label>
            <fieldset id="director_type">
                <label>
                    <input type="radio" value="En propiedad" name="director_type" checked> En propiedad
                </label>
                <br>
                <label>
                    <input type="radio" value="En funciones" name="director_type"> En funciones 
                </label>
            </fieldset>
        </div>

        <div class="form-group">
            <label>Empresa:</label>
            <fieldset id="company">
                <p>@{{message}}</p>
                <label>
                    <input type="radio" value="Sin empresa" name="company" @change="onChange($event)" checked> Sin empresa
                </label>
                <br> 
                @foreach($companies as $company)
                    <label>
                        <input type="radio" value="{{ $company->name }}" @change="onChange($event)" name="company"> {{ $company->name }}
                    </label>
                    <br> 
                @endforeach

               {{-- <company_depts :="{{ $companies->replies }}"></company_depts> --}} 
            </fieldset>
        </div>

        <div class="form-group">
            <label for="budget">Presupuesto:</label>
            <input type="number" class="form-control" name="budget" id="budget" aria-describedby="budgetHelp" value="10000">
            <small id="budgetHelp" class="form-text text-muted">Introduce el presupuesto (entre 10.000 y 100.000)</small>
        </div>

        <button type="submit" class="btn btn-success">Crear empresa</button>
        <a href="{{ route('departments.index') }}" class="btn btn-outline-primary">Regresar a listado de departamentos</a>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/vue"></script>

    <script type="text/javascript">

        var app = new Vue({
            el: '#company',
            data:{
                message: 'Sin empresa',
            },
            methods:{
                onChange(event) {
                    optionText = event.target.value;
                    this.message= optionText;
                }
            }
        })

    </script>

@endsection