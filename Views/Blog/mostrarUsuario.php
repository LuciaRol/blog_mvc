<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<h2>ESTA ES LA INFORMACIÓN DEL USUARIO</h2>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Nombre: <?php echo $nombre; ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted">Apellidos: <?php echo $apellidos; ?></h6>
                    <p class="card-text">Email: <?php echo $email; ?></p>
                    <p class="card-text">Nombre de usuario: <?php echo $username; ?></p>
                    <p class="card-text">Rol: <?php echo $rol; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>