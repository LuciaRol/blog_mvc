<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<div class="form-container">
    <h2 class="form-titulo">Añadir Nueva Categoría</h2>

    <?php if (!empty($mensaje)): ?>
        <p class="form-mensaje"><?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>

    <form class="categoria-form" method="post" action="<?= BASE_URL ?>?controller=Categoria&action=registroCategoria">
        <input class="form-input" type="text" name="nueva_categoria" placeholder="Nombre de la nueva categoría">
        <button class="form-btn" type="submit">Guardar</button>
    </form>

    <h2>Listado de Categorías</h2>

    <ul class="categoria-lista">
        <?php foreach ($categorias as $categoria): ?>
            <li class="categoria-item"><?= htmlspecialchars($categoria['nombre'], ENT_QUOTES, 'UTF-8'); ?></li>
        <?php endforeach; ?>
    </ul>
</div>





   
</body>
</html>