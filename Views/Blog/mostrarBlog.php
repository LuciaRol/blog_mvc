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
    
<table>
    <tr>
        <th class="subtitle subtitle2"><a href="<?=BASE_URL?>?controller=Blog&action=mostrarBlog&orden=concepto">Concepto</a></th>
        <th class="subtitle subtitle2"><a href="<?=BASE_URL?>?controller=Blog&action=mostrarBlog&orden=fecha">Fecha</a></th>
        <th class="subtitle subtitle2"><a href="<?=BASE_URL?>?controller=Blog&action=mostrarBlog&orden=importe">Importe (&euro;)</a></th>
        <th class="subtitle">Operaciones</th>
    </tr>

    <?php foreach ($registros as $registro): ?>
        <tr>
            <td><?= $registro['concepto'] ?></td>
            <td><?= $registro['fecha'] ?></td>
            <td><?= $registro['importe'] ?></td>
            <td>
                <div class="btn-container">
                    <!-- Dentro del bucle foreach para mostrar registros -->
                    <button type="button" class="btn editar-btn" data-id="<?= $registro['id'] ?>">Editar</button>

                    <form action="<?=BASE_URL?>?controller=Blog&action=borrarRegistro" method="POST">
                        <button class="btn" name="borrar" value="<?= $registro['id'] ?>">Borrar</button>
                    </form>
                </div>                
            </td>
        </tr>
        <tr class="edicion-campos" style="display: none;">
            <form action="<?=BASE_URL?>?controller=Blog&action=modificarRegistro" method="post">
                <!-- Campos ocultos para enviar el ID del registro -->
                <input type="hidden" name="id" value="<?= $registro['id'] ?>">
                <td><input type="text" name="concepto_editado" placeholder="Nuevo concepto"></td>
                <td><input type="text" name="fecha_editada" placeholder="Nueva fecha"></td>
                <td><input type="text" name="importe_editado" placeholder="Nuevo importe"></td>
                <td><button type="submit" class="btn" name="editar">Guardar</button></td>
            </form>
        </tr>

    <?php endforeach; ?>

    <form action="<?=BASE_URL?>?controller=Blog&action=guardarRegistro" method="POST">
        <td>
            <input type="text" name="concepto" placeholder="Concepto">
            <p class="error"></p>
        </td>
        <td>
            <input type="text" name="fecha" placeholder="Fecha">
            <p class="error"></p>
        </td>
        <td>
            <input type="text" name="importe" placeholder="Importe">
            <p class="error"></p>
        </td>
        <td>
            <button id="registro" class="btn" type="submit">Añadir registro</button>
        </td>
    </form>
</table>

<div id="error-messages">
    <?php if (!empty($errores)): ?>
        <ul>
            <?php foreach ($errores as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<div class="linea"></div>

<div id="buscarConcepto">
    <p>Buscar por concepto: </p>
    <form action="<?=BASE_URL?>?controller=Blog&action=buscarRegistro" method="POST">
        <input class="buscar" type="text" name="buscar">
        <button class="btn" type="submit">Buscar</button>
    </form>
</div>

<div class="linea"></div>
    
<div class="anotaciones">
    <div>
        <p>El numero total de registros es: <?= $BlogController->contarTotalRegistros() ?></p>
        <p id="balance">El balance total es de <?= $BlogController->calcularBalanceTotal() ?> &euro;</p>
    </div>
    <button class="btn"><a href="<?=BASE_URL?>?controller=Blog&action=mostrarBlog">Ver todas las anotaciones</a></button> 
    <!-- No asignamos valor a orden para volver al original de Blog.txt -->
</div>

<!-- SCRIPT JS PARA QUE SE MUESTRE EL FORMULARIO PARA EDITAR CUANDO SE PULSA EL BOTÓN "EDITAR" -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
    var editarBotones = document.querySelectorAll('.editar-btn');

    editarBotones.forEach(function(boton) {
        boton.addEventListener('click', function() {
            // Obtener el ID del registro correspondiente
            var idRegistro = this.getAttribute('data-id');
            console.log("ID del registro: ", idRegistro);

            // Ocultar todos los campos de edición
            var camposEdicion = document.querySelectorAll('.edicion-campos');
            camposEdicion.forEach(function(campos) {
                campos.style.display = 'none';
            });

            // Mostrar los campos de edición correspondientes al ID del registro
            var fila = this.closest('tr');
            var camposEdicionID = fila.nextElementSibling;
            camposEdicionID.style.display = 'table-row';
            });
        });
    });
</script>

</body>

</html>