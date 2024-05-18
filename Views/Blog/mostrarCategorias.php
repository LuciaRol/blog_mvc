<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<h2>Listado de Categorías</h2>

<ul>
    <?php foreach ($categorias as $categoria): ?>
        <li><?= $categoria['nombre']; ?></li>
    <?php endforeach; ?>
</ul>

<h3>Añadir Nueva Categoría</h3>

<?php if (!empty($mensaje)): ?>
    <p><?= $mensaje ?></p>
<?php endif; ?>

<form method="post" action="<?= BASE_URL ?>?controller=Blog&action=registroCategoria" method="POST">
    <input type="text" name="nueva_categoria" placeholder="Nombre de la nueva categoría">
    <button type="submit">Guardar</button>
</form>
   
</body>
</html>