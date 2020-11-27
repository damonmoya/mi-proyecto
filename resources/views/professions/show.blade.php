@extends('layout')

@section('title', "Profesión {$profession->id}")

@section('header')
    <div class="form-group mt-2 mt-md-0 mb-3 row align-items-end">
        <div class="col-10">
            <h1>Profesión #{{ $profession->id }} ({{ $profession->title }})</h1>
        </div>
    </div>
@endsection

@section('content')
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Profesionales</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $profession->title }}</td>
            <td>
                @if($users->isNotEmpty())
                    <ul>
                        @foreach($users as $user)
                            <li>{{ $user->name }}</li> 
                        @endforeach
                    </ul>
                @else
                    No hay profesionales
                @endif
            </td>
        </tr>
        </tbody>
    </table>

    <p>
        <a href="{{ route('professions.index') }} " class="btn btn-outline-primary">Regresar a listado de profesiones</a>
    </p>
        
@endsection