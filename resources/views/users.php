<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Listado de usuarios - Mi proyecto</title>

    </head>
<body>
    <h1><?= e($title) ?></h1>

<ul>
    <?php foreach ($users as $user): ?>
        <li><?= e($user) ?></li>
    <?php endforeach; ?>
</ul>


</body>
</html>
