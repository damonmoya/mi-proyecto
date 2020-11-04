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

if ($user->is_admin){
    $tipo_usuario = "Administrador";
} else {
    $tipo_usuario = "Usuario normal";
}

?>

@extends('layout')

@section('title', "Usuario {$user->id}")

@section('header')
    <h1>Usuario #{{ $user->id }} ({{ $user->name }})</h1>
@endsection

@section('content')
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Correo</th>
            <th scope="col">Profesión</th>
            <th scope="col">Tipo Usuario</th>
            <th scope="col">Creado en</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $oficio }}</td>
            <td>{{ $tipo_usuario }}</td>
            <td>{{ $user->created_at }}</td>
        </tr>
        </tbody>
    </table>
    @if (auth()->check())
        <?php
          $loggedUser = auth()->user();
        ?>
        @if ($loggedUser->is_admin)
            <p>
                <a href="{{ route('users.edit', [$user->id]) }}" class="btn btn-primary">Editar usuario</a> 
            </p>
        @endif
      @endif
    
    <p>
        <a href="{{ route('users.index') }} " class="btn btn-outline-primary">Regresar a listado de usuarios</a>
    </p>
@endsection



