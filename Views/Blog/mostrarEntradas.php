<?php
    // Incluir el controlador
    use Controllers\BlogController;

    // Crear una instancia del controlador
    $BlogController = new BlogController();

    // Configuración de la paginación
    $resultadosPorPagina = 5;
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
    <title>Mostrar Entradas</title>
</head>
<body>

<form method="post" action="<?= BASE_URL ?>?controller=Blog&action=mostrarEntradas" method="POST">
    <label for="titulo">Título:</label><br>
    <input type="text" id="titulo" name="titulo"><br>
    
    <label for="descripcion">Descripción:</label><br>
    <textarea id="descripcion" name="descripcion"></textarea><br>
    
    <label for="categoria">Categoría:</label><br>
    <select id="categoria" name="categoria">
        <?php foreach ($categorias as $categoria): ?>
            <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></option>
        <?php endforeach; ?>
    </select><br>
    
    <input type="submit" value="Enviar">
</form>

<main>
    <div>
        <h2>Últimos artículos</h2>
        <?php if ($noResults): ?>
            <p>No se ha encontrado nada con la palabra "<?php echo htmlspecialchars($searchQuery, ENT_QUOTES, 'UTF-8'); ?>"</p>
        <?php else: ?>
            <?php if (!empty($searchQuery)): ?>
                <h3>Resultados de búsqueda para "<?php echo htmlspecialchars($searchQuery, ENT_QUOTES, 'UTF-8'); ?>"</h3>
            <?php endif; ?>
            <?php if (!empty($entradasPaginadas)): ?>
                <!-- ENTRADAS -->
                <table>
                    <tbody>
                        <?php foreach ($entradasPaginadas as $entrada): ?>
                            <tr>
                                <td>
                                    <h3><?php echo htmlspecialchars($entrada['titulo'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                    <p><?php echo htmlspecialchars($entrada['descripcion'], ENT_QUOTES, 'UTF-8'); ?></p>
                                    <div>
                                        <form action="">
                                            <button type="button">Editar</button>
                                        </form>
                                        <form action="">
                                            <button type="button">Borrar</button>
                                        </form>
                                    </div> 
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Paginación -->
                <?php if ($paginasTotales > 1): ?>
                    <div>
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

</main>

</body>
</html>