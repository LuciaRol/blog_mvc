<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos del usuario</title>
</head>
<body>

<div class="container mt-5">
    <h2>Datos del usuario</h2>
    <?php
    // Verificar si hay errores y mostrar el mensaje
    if (isset($error_message) && is_array($error_message)) {
        echo "<ul>";
        foreach ($error_message as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }
    ?>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Nombre: <?php echo htmlspecialchars($nombre); ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted">Apellidos: <?php echo htmlspecialchars($apellidos); ?></h6>
                    <p class="card-text">Email: <?php echo htmlspecialchars($email); ?></p>
                    <p class="card-text">Nombre de usuario: <?php echo htmlspecialchars($username); ?></p>
                    <p class="card-text">Rol: <?php echo htmlspecialchars($rol); ?></p>

                    <form action="<?= BASE_URL ?>?controller=Usuario&action=actualizarUsuario" method="post">
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
                        <?php if ($rol === 'admin'): ?>
                        <div class="mb-3">
                            <label for="rol" class="form-label">Rol:</label>
                            <select class="form-select" id="rol" name="rol">
                                <option value="usur" <?php if ($rol == 'usur') echo 'selected'; ?>>usur</option>
                                <option value="admin" <?php if ($rol == 'admin') echo 'selected'; ?>>admin</option>
                            </select>
                        </div>
                        <?php endif; ?>
                        <input type="submit" class="login_btn btn btn-primary" value="Guardar">
                    </form>

                </div>
            </div>
        </div>
    </div>
<!-- Mostrar la tabla de usuarios solo si el rol es 'admin' -->
<?php if ($rol === 'admin'): ?>
<div class="row">
    <div class="col-md-12">
        <h3>Listado de Usuarios</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Email</th>
                    <th>Nombre de usuario</th>
                    <th>Rol</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?php echo $usuario['id']; ?></td>
                    <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['apellidos']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['username']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

</div>

</body>
</html>
