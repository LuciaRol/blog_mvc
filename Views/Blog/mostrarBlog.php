<?php
    // Incluir el controlador
    use Controllers\BlogController;

    // Crear una instancia del controlador
    $BlogController = new BlogController();

    // Configuración de la paginación
    $resultadosPorPagina = 4;
    $paginaActual = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $totalResultados = count($entradas);
    $paginasTotales = ceil($totalResultados / $resultadosPorPagina);
    $offset = ($paginaActual - 1) * $resultadosPorPagina;
    $entradasPaginadas = array_slice($entradas, $offset, $resultadosPorPagina);

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
            
            <!-- Formulario para filtrar por categorias -->
            <form class="filtrar_categoria" action="<?= BASE_URL ?>?controller=Blog&action=buscarPorCategoria" method="POST">
            <label for="categoria">Seleccione una categoría:</label>
                <select id="categoria" name="categoria">
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?php echo htmlspecialchars($categoria['nombre'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($categoria['nombre'], ENT_QUOTES, 'UTF-8'); ?></option>
                    <?php endforeach; ?>
                </select>

             <button type="submit" class="search_button">Filtrar Categoria</button>
            </form>

            <div class="msg_categoria">
                <?php if ($noResults): ?>
                    <p >No se ha encontrado nada con la palabra o categoria "<?php echo htmlspecialchars($searchQuery, ENT_QUOTES, 'UTF-8'); ?>"</p>
                <?php else: ?>
                    
                <?php if (!empty($searchQuery)): ?>
                    <p>Resultados de búsqueda para "<?php echo htmlspecialchars($searchQuery, ENT_QUOTES, 'UTF-8'); ?>"</p>
                <?php endif; ?>
            </div>

            

                <!-- ARTÍCULOS -->
                <h2>Últimos artículos</h2>
                <?php if (!empty($entradasPaginadas)): ?>
                    <ul class="entrada-lista">
                        <?php $count = 0; ?>
                        <?php foreach ($entradasPaginadas as $entrada): ?>
                            <li class="entrada-item">
                                <h3 class="entrada-titulo"><?php echo htmlspecialchars($entrada['titulo'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                <p class="entrada-descripcion"><?php echo htmlspecialchars($entrada['descripcion'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <p class="entrada-categoria"><strong><?php echo htmlspecialchars($entrada['categoria'], ENT_QUOTES, 'UTF-8'); ?></strong></p>
                            </li>
                            <?php $count++; ?>
                            <?php if ($count % 2 == 0): ?>
                                <div class="break"></div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>



                    <!-- Paginación -->
                    <?php if ($paginasTotales > 1): ?>
                        <div class="pagination">
                            <?php if ($paginaActual > 1): ?>
                                <a href="?page=<?php echo $paginaActual - 1; ?>">Anterior</a>
                            <?php endif; ?>
                            <?php for ($i = 1; $i <= $paginasTotales; $i++): ?>
                                <?php if ($i == $paginaActual): ?>
                                    <span><?php echo $i; ?></span>
                                <?php else: ?>
                                    <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                <?php endif; ?>
                            <?php endfor; ?>
                            <?php if ($paginaActual < $paginasTotales): ?>
                                <a href="?page=<?php echo $paginaActual + 1; ?>">Siguiente</a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <p>No hay entradas disponibles.</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <aside class="sidebar">
            <h3 class="sidebar_title">¡Regístrate ahora!</h3>
            <?php
            // Verificar si hay errores de registro y mostrar el mensaje
            if (isset($error_registro) && is_array($error_registro)) {
                echo "<ul>";
                foreach ($error_registro as $error) {
                    echo "<li>$error</li>";
                }
                echo "</ul>";
            }
            ?>
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