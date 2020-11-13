<!DOCTYPE html>
<html>
<head>
    <title>Detalle empresa</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic-bootstrap.css" integrity="sha512-CdBAHV63xsk13rW8Wd6u6S1SqfW6TXXE/2HvYpeiCaQSJhEuathtzO87zloBMqQKW7JoqTixSvWlm6aj4722WQ==" crossorigin="anonymous" />
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

    <h1>Empresa #{{ $company->id }} ({{ $company->name }})</h1>

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

</body>
</html>



