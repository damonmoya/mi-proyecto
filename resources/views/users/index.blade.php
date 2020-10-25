@extends('layout')

@section('title', "Usuarios")

@section('content')
<h1>{{ $title }}</h1>
     @if (! empty($users))       

        <ul>
            @foreach ($users as $user)
                <li>{{ $user }}</li>
            @endforeach
        </ul>
    @else 
        <p>No hay usuarios registrados</p>
    @endif
@endsection

