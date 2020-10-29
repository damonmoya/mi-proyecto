<?php

use App\Models\Profession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

$profession = Profession::find($user->profession_id);

if ($profession == null){
    $oficio = "Sin profesión asignada";
} else {
    $oficio = $profession->title;
}

?>

@extends('layout')

@section('title', "Usuario {$user->id}")

@section('content')
    <h1>Usuario #{{ $user->id }}</h1>

    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Correo</th>
            <th scope="col">Profesión</th>
            <th scope="col">Acciones</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $oficio }}</td>
            <td>
                <form action="{{ route('users.destroy', [$user->id]) }}" method="POST">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <a href="{{ route('users.edit', [$user->id]) }}" class="btn btn-primary"><span class="oi oi-pencil"></span></a> 
                    <button type="submit" class="btn btn-danger"><span class="oi oi-trash"></span></button>
                </form>
            </td>
        </tr>
        </tbody>
    </table>

    <a href="{{ url('/usuarios') }} " class="btn btn-outline-primary">Regresar a listado de usuarios</a>

@endsection



