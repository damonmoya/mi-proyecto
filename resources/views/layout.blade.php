<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>@yield('title') - Mi proyecto</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sticky-footer-navbar/">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic-bootstrap.css" integrity="sha512-CdBAHV63xsk13rW8Wd6u6S1SqfW6TXXE/2HvYpeiCaQSJhEuathtzO87zloBMqQKW7JoqTixSvWlm6aj4722WQ==" crossorigin="anonymous" />
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css"> 
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="/css/style.css">
  </head>

  <body>

    <header>
      <!-- Fixed navbar -->
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-primary">
        <a class="navbar-brand" href="{{ route('home') }}">Mi proyecto</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="{{ route('home') }}">Inicio<span class="sr-only">(current)</span></a>
            </li>
            @if (auth()->check())
              <?php
                $user = auth()->user();
              ?>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('users.index') }}">Usuarios</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('companies.index') }}">Empresas</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('departments.index') }}">Departamentos</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('professions.index') }}">Profesiones</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('users.show', $user->id) }}">Perfil</a>
              </li>
              @hasrole('Administrador')
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('admin.index') }}">Admin</a>
                </li>
              @endhasrole
            @endif
          </ul>
        </div>
        <div class="navbar-collapse collapse w-100 order-3">
        <ul class="navbar-nav ml-auto">

          @if (auth()->check())
          <?php
            $user = auth()->user();
          ?>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('users.show', $user->id) }}">Sesión iniciada como: {{ $user->name }}</a>
            </li>
            <li class="nav-item">
              <form method="POST" action="{{ route('logout') }}">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
              </form>
            </li>
          @else
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
            </li>
          @endif
            
        </ul>
    </div>
      </nav>
    </header>

    <!-- Begin page content -->
    <main role="main" class="container">

      <div class="title">
        @yield('header')
      </div>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/vue"></script>
      <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
      @yield('content')
    </main>

    <footer class="footer bg-dark text-white">
      <div class="container">
        <span class="text-muted">Proyecto con Laravel</span>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  </body>
</html>