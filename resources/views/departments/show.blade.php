@extends('layout')

@section('title', "Departamento {$department->id}")

@section('header')
    <div class="form-group mt-2 mt-md-0 mb-3 row align-items-end">
        <div class="col-10">
            <h1>Departamento #{{ $department->id }} ({{ $department->name }})</h1>
        </div>
        <div class="col-2" id="enviar_pdf">
            <a href='#' class="btn btn-primary" v-on:click.prevent="send_email_pdf">Enviar correo con PDF</a>
        </div>
    </div>
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

        <p>
            <a href="{{ route('departments.index') }} " class="btn btn-outline-primary">Regresar a listado de departamentos</a>
        </p>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <script>
            const app = new Vue({ 
                el: '#enviar_pdf',
                data: {
                    department: @json($department)
                },
                methods: {
                    send_email_pdf() {
                        var msg = 'Generando PDF con detalle del departamento ' + this.department.name + '...';
                        toastr.info(msg, "Info", {"positionClass": "toast-bottom-right"});
                        axios.get('/departamentos/send_email', { params: { id: this.department.id } })
                                .then(response => {
                                    var msg = '¡Se ha enviado el pdf a tu correo (' + response.data + ')!';
                                    toastr.success(msg, "Correo enviado", {"positionClass": "toast-bottom-right"});  
                                }).catch(error => {});
                    }
                }
            })
        </script>
    
@endsection