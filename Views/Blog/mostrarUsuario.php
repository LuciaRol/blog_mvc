<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<div class="container mt-5">
    <h2>ESTA ES LA INFORMACIÓN DEL USUARIO</h2>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Nombre: <?php echo htmlspecialchars($nombre); ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted">Apellidos: <?php echo htmlspecialchars($apellidos); ?></h6>
                    <p class="card-text">Email: <?php echo htmlspecialchars($email); ?></p>
                    <p class="card-text">Nombre de usuario: <?php echo htmlspecialchars($username); ?></p>
                    <p class="card-text">Rol: <?php echo htmlspecialchars($rol); ?></p>

                    <form action="<?= BASE_URL ?>?controller=Blog&action=actualizarUsuario" method="post">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="apellidos" class="form-label">Apellidos:</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($apellidos); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Nombre de usuario:</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="rol" class="form-label">Rol:</label>
                            <select class="form-select" id="rol" name="rol">
                                <option value="usur" <?php if ($rol == 'usur') echo 'selected'; ?>>usur</option>
                                <option value="admin" <?php if ($rol == 'admin') echo 'selected'; ?>>admin</option>
                            </select>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Guardar">
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>