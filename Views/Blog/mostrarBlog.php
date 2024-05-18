<?php
    // Incluir el controlador
    use Controllers\BlogController;

    // Crear una instancia del controlador
    $BlogController = new BlogController();
  
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
</head>
<body>
    <main class="grid-container">
        <div class="content">
            <h2>Últimos artículos</h2>
            <?php if ($noResults): ?>
                <p>No se ha encontrado nada con la palabra "<?php echo htmlspecialchars($searchQuery, ENT_QUOTES, 'UTF-8'); ?>"</p>
            <?php else: ?>
                <?php if (!empty($searchQuery)): ?>
                    <h3>Resultados de búsqueda para "<?php echo htmlspecialchars($searchQuery, ENT_QUOTES, 'UTF-8'); ?>"</h3>
                <?php endif; ?>
                <?php if (!empty($entradas)): ?>
                    <ul>
                        <?php foreach ($entradas as $entrada): ?>
                            <li>
                                <h3><?php echo htmlspecialchars($entrada['titulo'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                <p><?php echo htmlspecialchars($entrada['descripcion'], ENT_QUOTES, 'UTF-8'); ?></p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No hay entradas disponibles.</p>
                <?php endif; ?>
            <?php endif; ?>

        </div>

        <aside class="sidebar">
            <h3 class="sidebar_title">¡Regístrate ahora!</h3>
            <form action="<?= BASE_URL ?>?controller=Blog&action=registroUsuario" method="POST">
            <div class="sidebar_inputs">
           
                <input type="text" class="sidebar_input" placeholder="Nombre" name="nombre">
                <input type="text" class="sidebar_input" placeholder="Apellidos" name="apellidos">
                <input type="email" class="sidebar_input" placeholder="Email" name="email">
                <input type="username" class="sidebar_input" placeholder="Username" name="username">
                <input type="password" class="sidebar_input" placeholder="Contraseña" name="contrasena">
                <button type="submit" class="sidebar_btn" name="registro">Registrarse</button>

           
            </div>
            </form>
        </aside>       
    </main>
</body>

</html>