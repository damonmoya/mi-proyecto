<!DOCTYPE html>
<html>
<head>
    <title>Detalle usuario</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic-bootstrap.css" integrity="sha512-CdBAHV63xsk13rW8Wd6u6S1SqfW6TXXE/2HvYpeiCaQSJhEuathtzO87zloBMqQKW7JoqTixSvWlm6aj4722WQ==" crossorigin="anonymous" />
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

    <h1>Usuario #{{ $user->id }} ({{ $user->name }})</h1>

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Correo</th>
                <th scope="col">Profesión</th>
                <th scope="col">Departamento</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $oficio }}</td>
                <td>{{ $departamento_usuario }}</td>
            </tr>
        </tbody>

        <thead class="thead-dark">
            <tr>
                <th scope="col">Departamento dependiente</th>
                <th scope="col">Empresa</th>
                <th scope="col">Tipo Usuario</th>
                <th scope="col">Creado en</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $departamento_dependiente }}</td>
                <td>{{ $empresa }}</td>
                <td>{{ $tipo_usuario }}</td>
                <td>{{ $user->created_at }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>



