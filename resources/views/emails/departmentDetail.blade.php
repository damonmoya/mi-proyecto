<!DOCTYPE html>
<html>
<head>
    <title>Detalle departamento</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic-bootstrap.css" integrity="sha512-CdBAHV63xsk13rW8Wd6u6S1SqfW6TXXE/2HvYpeiCaQSJhEuathtzO87zloBMqQKW7JoqTixSvWlm6aj4722WQ==" crossorigin="anonymous" />
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

    <h1>Departamento #{{ $department->id }} ({{ $department->name }})</h1>
    
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

</body>
</html>



