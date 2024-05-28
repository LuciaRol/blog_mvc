
<body>
<div class="form-container">
    <?php if ($esAdmin): ?>
        <h2 class="form-titulo">Añadir Nueva Categoría</h2>

        <?php if (!empty($mensaje)): ?>
            <p class="form-mensaje"><?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>

        <form class="categoria-form" method="post" action="<?= htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8'); ?>?controller=Categoria&action=registroCategoria">
            <input class="form-input" type="text" name="nueva_categoria" placeholder="Nombre de la nueva categoría" required>
            <button class="form-btn" type="submit">Guardar</button>
        </form>
    <?php endif; ?>

    <h2>Listado de Categorías</h2>

    <ul class="categoria-lista">
        <?php foreach ($categorias as $categoria): ?>
            <li class="categoria-item"><?= htmlspecialchars($categoria['nombre'], ENT_QUOTES, 'UTF-8'); ?></li>
        <?php endforeach; ?>
    </ul>
</div>
</body>
</html>
