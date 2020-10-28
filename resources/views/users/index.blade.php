@extends('layout')

@section('title', "Usuarios")

@section('content')
    <h1>{{ $title }}</h1>
     
    <ul>
        @forelse ($users as $user)
            <li>
                {{ $user->name }}, ({{ $user->email }})
                <a href="{{ route('users.show', [$user->id]) }}">Ver detalles</a> |
                <a href="{{ route('users.edit', [$user->id]) }}">Modificar</a>
            </li>
        @empty
            <li>No hay usuarios registrados</li>
        @endforelse
    </ul>

@endsection

