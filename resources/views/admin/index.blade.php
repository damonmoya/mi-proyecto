@extends('layout')

@section('title', "Panel administración")

@section('content')
    <div class="row">
        <div class="col">
            <h1>Panel de administración</h1>
        </div>
    </div>
  <div class="row">
    <div class="col">

        <div id="control_admin">
          <table class="table table-bordered table-striped">
              <thead class="thead-dark">
                <h3>Papelera de usuarios</h3>
              </div>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Correo</th>
                <th scope="col">Acciones</th>
              </tr>
              </thead>
              <tbody v-if="users.length > 0">
                    <tr v-for="user in users" :key="user.id">
                        <td> @{{ user.id }} </td>
                        <td> @{{ user.name }} </td>
                        <td> @{{ user.email }} </td>
                        <td>
                            <a :href="'/usuarios/' + user.id" class='btn btn-info'><span class='oi oi-eye'></span></a>
                            @hasrole('Administrador')
                                <a href='#' class='btn btn-primary' v-on:click.prevent="editUser(user)"><span class='oi oi-pencil'></span></a> 
                                <a href='#' class='btn btn-danger' v-on:click.prevent="deleteUser(user)"><span class='oi oi-trash'></span></a>
                            @endhasrole
                        </td>
                    </tr>
            </tbody>
          </table>
        </div>
        
    </div>
  </div>


  
<script>
      const app = new Vue({ 
          el: '#control_admin',
          created: function() {
              this.getUsers();
              this.getDepartments();
              this.getProfessions();
              this.getCompanies();
          },
          data: {
              users: [],
              departments: [],
              professions: [],
              companies: []
          },
          methods: {
              getUsers: function(){
                  var urlUsers = "{{ route('users.resources') }}";
                  axios.get(urlUsers).then(response => {
                      this.totalUsers = response.data.length
                  });
              },
              getDepartments: function(){
                  var urlDepartment = "{{ route('departments.resources') }}";
                  axios.get(urlDepartment).then(response => {
                      this.totalDepartments = response.data.length
                  });
              },
              getProfessions: function(){
                  var urlCompanies = "{{ route('companies.resources') }}";
                  axios.get(urlCompanies).then(response => {
                      this.totalCompanies = response.data.length
                  });
              },
              getCompanies: function(){
                  var urlProfession = "{{ route('professions.resources') }}";
                  axios.get(urlProfession).then(response => {
                      this.totalProfessions = response.data.length
                  });
              }
          }
      })

</script>
            
@endsection