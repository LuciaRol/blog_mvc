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
    <title>Mostrar Entradas</title>
</head>
<body>

<!-- Formulario para crear nueva entrada -->
<form method="post" action="<?= BASE_URL ?>?controller=Blog&action=mostrarEntradas">
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

<!-- Listado de entradas existentes -->
<?php if (!empty($entradas)): ?>
    <ul>
        <?php foreach ($entradas as $entrada): ?>
            <li>
                <form method="post" action="<?= BASE_URL ?>?controller=Blog&action=mostrarEntradas">
                    <input type="hidden" name="entrada_id" value="<?php echo $entrada['entrada_id']; ?>">
                    
                    <label for="titulo_<?php echo $entrada['entrada_id']; ?>">Título:</label>
                    <input type="text" id="titulo_<?php echo $entrada['entrada_id']; ?>" name="titulo" value="<?php echo $entrada['titulo']; ?>"><br>
                    
                    <label for="descripcion_<?php echo $entrada['entrada_id']; ?>">Descripción:</label>
                    <textarea id="descripcion_<?php echo $entrada['entrada_id']; ?>" name="descripcion"><?php echo $entrada['descripcion']; ?></textarea><br>
                    
                    <label for="categoria<?php echo $entrada['entrada_id']; ?>">Categoría:</label>
                    <select id="categoria<?php echo $entrada['entrada_id']; ?>" name="categoria">
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?php echo $categoria['id']; ?>" <?php echo ($entrada['categoria'] == $categoria['nombre']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($categoria['nombre'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select><br>
                    <input type="submit" value="Guardar cambios">
                    
                </form>
                <form method="post" action="<?= BASE_URL ?>?controller=Blog&action=eliminarEntrada">
                        <input type="hidden" name="entrada_id" value="<?php echo $entrada['entrada_id']; ?>">
                        <input type="submit" value="Eliminar">
                    </form>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No hay entradas disponibles.</p>
<?php endif; ?>


</body>
</html>
