@extends('layout')

@section('title', "Página principal")

@section('content')
    <div class="row">
        <div class="col">
            <h1>Página principal</h1>
        </div>
    </div>
  <div class="row">
    <div class="col">

      @if (auth()->check())
        <?php
          $user = auth()->user();
        ?>
        <h3>¡Saludos, {{ $user->name }}!</h3>
        <a href="{{ route('users.index') }}" class="btn btn-outline-primary">Ir a Listado de usuarios</a>
      @else
        <h3>¡Bienvenido, visitante!</h3>
        <a href="{{ route('login') }}" class="btn btn-outline-primary">Iniciar sesión</a>
      @endif
        
    </div>
  </div>
            
@endsection