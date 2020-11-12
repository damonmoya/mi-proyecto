@extends('layout')

@section('title', "Departamento {$department->id}")

@section('header')
    <h1>Departamento #{{ $department->id }} ({{ $department->name }})</h1>
@endsection

@section('content')
    <h2>Detalles</h2>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Director</th>
            <th scope="col">Tipo director</th>
            <th scope="col">Presupuesto</th>
            <th scope="col">Empresa</th>
            <th scope="col">Dept. dependientes</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $department->name }}</td>
            <td>{{ $department->director }}</td>
            <td>{{ $department->director_type }}</td>
            <td>{{ $department->budget }}€</td>
            <td>{{ $company }}</td>
            <td>
                @if($dependents->isNotEmpty())
                    <ul>
                        @foreach($dependents as $dependent)
                            <li>{{ $dependent->name }}</li> 
                        @endforeach
                    </ul>
                @else
                    No hay departamentos dependientes
                @endif
            </td>
        </tr>
        </tbody>
    </table>

    <h2>Empleados</h2>
    @if($employees->isNotEmpty())
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Correo</th>
            </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                    <tr>
                        <td>{{ $employee->id }}</td>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->email }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <h3>No hay empleados</h3>
    @endif

    @if(! $hide)

        @can('Editar departamento')
            <p>
                <a href="{{ route('departments.edit', [$department->id]) }}" class="btn btn-primary">Editar departamento</a> 
            </p>
        @endcan

        <p>
            <a class="btn btn-primary noprint" href="{{route('departments.show', ['id' => $department->id, 'download'=>'pdf'])}}">Descargar en PDF</a>
        </p>

        <p>
            <a href="{{ route('departments.index') }} " class="btn btn-outline-primary">Regresar a listado de departamentos</a>
        </p>
    
    @endif
@endsection