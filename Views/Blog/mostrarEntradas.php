<h4?php
// Incluir el controlador
use Controllers\BlogController;

// Crear una instancia del controlador
$BlogController = new BlogController();

?>

<body>

<!-- Formulario para crear nueva entrada -->
<form class="entrada-form" method="post" action="<?= BASE_URL ?>?controller=Entrada&action=mostrarEntradas">
    <h2>Nueva entrada</h2>
    <label for="titulo" class="form-label">Título:</label><br>
    <input type="text" id="titulo" name="titulo" class="form-input"><br>
    
    <label for="descripcion" class="form-label">Descripción:</label><br>
    <textarea id="descripcion" name="descripcion" class="form-textarea"></textarea><br>
    
    <label for="categoria" class="form-label">Categoría:</label><br>
    <select id="categoria" name="categoria" class="form-select">
        <?php foreach ($categorias as $categoria): ?>
            <option value="<?php echo $categoria['id']; ?>" class="form-option"><?php echo $categoria['nombre']; ?></option>
        <?php endforeach; ?>
    </select><br>
    
    <input type="submit" value="Enviar" class="form-btn">
</form>

<?php if (isset($error_message)): ?>
    <p class="form-error"><?= $error_message ?></p>
<?php endif; ?>



<!-- Listado de entradas existentes -->
<?php if (!empty($entradas)): ?>
    <h2>Editar entrada</h2>
    <ul class="entrada-lista">
        <?php foreach ($entradas as $entrada): ?>
            <li class="entrada-item">
                <form class="entrada-edit-form" method="post" action="<?= BASE_URL ?>?controller=Entrada&action=mostrarEntradas">
                    <input type="hidden" name="entrada_id" value="<?php echo $entrada['entrada_id']; ?>">
                    
                    <label for="titulo_<?php echo $entrada['entrada_id']; ?>" class="form-label">Título:</label>
                    <input type="text" id="titulo_<?php echo $entrada['entrada_id']; ?>" name="titulo" value="<?php echo $entrada['titulo']; ?>" class="form-input"><br>
                    
                    <label for="descripcion_<?php echo $entrada['entrada_id']; ?>" class="form-label">Descripción:</label>
                    <textarea id="descripcion_<?php echo $entrada['entrada_id']; ?>" name="descripcion" class="form-textarea"><?php echo $entrada['descripcion']; ?></textarea><br>
                    
                    <label for="categoria<?php echo $entrada['entrada_id']; ?>" class="form-label">Categoría:</label>
                    <select id="categoria<?php echo $entrada['entrada_id']; ?>" name="categoria" class="form-select">
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?php echo $categoria['id']; ?>" <?php echo ($entrada['categoria'] == $categoria['nombre']) ? 'selected' : ''; ?> class="form-option">
                                <?php echo htmlspecialchars($categoria['nombre'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select><br>
                    <input type="submit" value="Guardar cambios" class="form-btn">
                </form>
                <form method="post" action="<?= BASE_URL ?>?controller=Entrada&action=eliminarEntrada">
                    <input type="hidden" name="entrada_id" value="<?php echo $entrada['entrada_id']; ?>">
                    <input type="submit" value="Eliminar" class="form-btn form-btn-danger">
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <h4 class="form-message" style="display: flex; justify-content: center;">No hay entradas disponibles para editar. Primero has de escribir una nueva.</h4>

<?php endif; ?>



</body>
</html>
