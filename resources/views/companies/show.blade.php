@extends('layout')

@section('title', "Empresa {$company->id}")

@section('header')
    <div class="form-group mt-2 mt-md-0 mb-3 row align-items-end">
        <div class="col-10">
            <h1>Empresa #{{ $company->id }} ({{ $company->name }})</h1>
        </div>
        <div class="col-2" id="enviar_pdf">
            <a a href='#' class="btn btn-primary" v-on:click.prevent="send_email_pdf">Enviar correo con PDF</a>
        </div>
    </div>
@endsection

@section('content')
    <h2>Detalles</h2>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Dirección</th>
            <th scope="col">Departamentos</th>
            <th scope="col">Nº de empleados</th>
            <th scope="col">Contacto</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $company->name }}</td>
            <td>{{ $company->address }}</td>
            <td>
                @if($departments->isNotEmpty())
                    <ul>

                            @foreach($departments as $department)
                                <li>{{ $department->name }}</li> 
                            @endforeach

                    </ul>
                @else
                    No hay departamentos
                @endif
            </td>
            <td>{{ $cuenta_empleados }}</td>
            <td>{{ $company->contact }}</td>
        </tr>
        </tbody>
    </table>

    <h2>Departamentos</h2>

    @if($departments->isNotEmpty())
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Director</th>
                <th scope="col">Cond. Director</th>
                <th scope="col">Presupuesto</th>
                <th scope="col">Dept. Dependiente</th>
                <th scope="col">Nº Empleados</th>
            </tr>
            </thead>
            <tbody>
            @foreach($departments as $department)
                <tr>
                    <td>{{ $department->name }}</td>
                    <td>{{ $department->director }}</td>
                    <td>{{ $department->director_type }}</td>
                    <td>{{ $department->budget }} €</td>
                    <td> {{ $array2[$department->name] }} </td>
                    <td> {{ $array[$department->name] }} </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <h3>No hay departamentos</h3>
    @endif
    
    <p>
        <a href="{{ route('companies.index') }} " class="btn btn-outline-primary">Regresar a listado de empresas</a>
    </p>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        const app = new Vue({ 
            el: '#enviar_pdf',
            data: {
                company: @json($company)
            },
            methods: {
                send_email_pdf() {
                    var msg = 'Generando PDF con detalle de la empresa ' + this.company.name + '...';
                    toastr.info(msg, "Info", {"positionClass": "toast-bottom-right"});
                    axios.get('/empresas/send_email', { params: { id: this.company.id } })
                            .then(response => {
                                var msg = '¡Se ha enviado el pdf a tu correo (' + response.data + ')!';
                                toastr.success(msg, "Correo enviado", {"positionClass": "toast-bottom-right"});  
                            }).catch(error => {});
                }
            }
        })
    </script>

@endsection