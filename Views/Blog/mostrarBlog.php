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
                <ul>
                    <?php foreach ($entradas as $entrada): ?>
                        <li>
                            <h3><?php echo $entrada['titulo']; ?></h3>
                            <p><?php echo $entrada['descripcion']; ?></p>
                            <!-- Agregar más detalles de la entrada según sea necesario -->
                        </li>
                    <?php endforeach; ?>
                </ul>
        </div>


        <aside class="sidebar">
            <h3 class="sidebar_title">¡Regístrate ahora!</h3>
            <div class="sidebar_inputs">
                <input type="text" class="sidebar_input" placeholder="Nombre">
                <input type="text" class="sidebar_input" placeholder="Apellidos">
                <input type="email" class="sidebar_input" placeholder="Email">
                <input type="password" class="sidebar_input" placeholder="Contraseña">
                <button type="submit" class="sidebar_btn">Registrarse</button>
            </div>
        </aside>
    </main>

</body>

</html>