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

        <div id="control_home">
          <table class="table table-bordered table-striped">
              <thead class="thead-dark">
                <h3>Índice de registros</h3>
              </div>
              <tr>
                  <th scope="col">Registro</th>
                  <th scope="col">Número de registros</th>
                  <th scope="col">Enlaces</th>
              </tr>
              </thead>
              <tbody>
                      <tr>
                          <td> Usuarios </td>
                          <td> @{{ totalUsers }} </td>
                          <td> <a href="{{ route('users.index') }}" class="btn btn-outline-primary">Ir a Listado de usuarios</a> </td>
                      </tr>
                      <tr>
                          <td> Profesiones </td>
                          <td> @{{ totalProfessions }} </td>
                          <td> <a href="{{ route('professions.index') }}" class="btn btn-outline-primary">Ir a Listado de profesiones</a> </td>
                      </tr>
                      <tr>
                          <td> Empresas </td>
                          <td> @{{ totalCompanies }} </td>
                          <td> <a href="{{ route('companies.index') }}" class="btn btn-outline-primary">Ir a Listado de empresas</a> </td>
                      </tr>
                      <tr>
                          <td> Departamentos </td>
                          <td> @{{ totalDepartments }} </td>
                          <td> <a href="{{ route('departments.index') }}" class="btn btn-outline-primary">Ir a Listado de departamentos</a> </td>
                      </tr>
              </tbody>
          </table>
        </div>
      @else
        <h3>¡Bienvenido, visitante!</h3>
        <a href="{{ route('login') }}" class="btn btn-outline-primary">Iniciar sesión</a>
      @endif
        
    </div>
  </div>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>

        const app = new Vue({ 
            el: '#control_home',
            created: function() {
                this.getUsers();
                this.getDepartments();
                this.getProfessions();
                this.getCompanies();
            },
            data: {
                totalUsers: 0,
                totalDepartments: 0,
                totalProfessions: 0,
                totalCompanies: 0
            },
            methods: {
                getUsers: function(){
                    var urlUsers = '/usuarios/recursos';
                    axios.get(urlUsers).then(response => {
                        this.totalUsers = response.data.length
                    });
                },
                getDepartments: function(){
                    var urlDepartment = '/departamentos/recursos';
                    axios.get(urlDepartment).then(response => {
                        this.totalDepartments = response.data.length
                    });
                },
                getCompanies: function(){
                    var urlCompanies = '/empresas/recursos';
                    axios.get(urlCompanies).then(response => {
                        this.totalCompanies = response.data.length
                    });
                },
                getProfessions: function(){
                    var urlProfession = '/profesiones/recursos';
                    axios.get(urlProfession).then(response => {
                        this.totalProfessions = response.data.length
                    });
                }
            }
        })

</script>
            
@endsection