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
        <li><?php echo $categoria['nombre']; ?></li>
    <?php endforeach; ?>
</ul>
   
</body>
</html>