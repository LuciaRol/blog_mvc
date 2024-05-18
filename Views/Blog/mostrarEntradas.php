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

</body>
</html>