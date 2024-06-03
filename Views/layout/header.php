
<header class="header">
    <div class="header_first_div">
        <div class="header_principal">
            <div ><img class="principal_logo" src="Assets/img/nebulosa.png" alt=""></div>
            <h1 class="principal_title">Astro Wiki - Tu blog de astronomía</h1>
        </div>
        <nav class="nav_container">
            <a class="nav_link" href="<?= BASE_URL ?>?controller=Blog&action=mostrarblogsesion">Inicio</a>
            <a id="info-usuario-link" class="nav_link" href="<?= BASE_URL ?>?controller=Usuario&action=mostrarUsuario">Perfil</a>
            <a id="categorias-link" class="nav_link" href="<?= BASE_URL ?>?controller=Categoria&action=mostrarCategorias">Crear categorías</a>
            <a id="entradas-link" class="nav_link" href="<?= BASE_URL ?>?controller=Entrada&action=mostrarEntradas">Crear entradas</a>
        </nav>
    </div>

    <div class="header_second_div">
        <div class="search_container">
            <form action="<?= BASE_URL ?>?controller=Blog&action=buscar" method="POST">
                <input class="search_input" type="text" name="q" placeholder="Busca">
                <button type="submit" class="search_button login_btn">Buscar</button>
            </form>
            
        </div>
        

        <div class="login_container">
            <?php if (isset($_SESSION['username'])): ?>
                <p class="hola">Hola, <?= htmlspecialchars($_SESSION['username']); ?></p>
                <form action="<?= BASE_URL ?>?controller=Blog&action=logout" method="POST">
                    <button type="submit" class="logout_button login_btn">Cerrar sesión</button>
                </form>
            <?php else: ?>
                <form action="<?= BASE_URL ?>?controller=Blog&action=login" method="POST">
                    <input class="login_user" type="text" name="username" placeholder="Usuario" required>
                    <input class="login_pass" type="password" name="password" placeholder="Contraseña" required>
                    <button class="login_btn" type="submit">Iniciar sesión</button>
                    <?php if (isset($loginError)): ?>
                        <p><?= htmlspecialchars($loginError); ?></p>
                    <?php endif; ?>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <!-- Script que hacer saltar un mensaje cuando un usuario no identificado quiere entrar en secciones restingidas -->                   
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Obtener los enlaces
            var infoUsuarioLink = document.getElementById('info-usuario-link');
            var categoriasLink = document.getElementById('categorias-link');
            var entradasLink = document.getElementById('entradas-link');

            // Agregar un evento de clic a cada enlace
            infoUsuarioLink.addEventListener('click', mostrarMensaje);
            categoriasLink.addEventListener('click', mostrarMensaje);
            entradasLink.addEventListener('click', mostrarMensaje);

            // Función para mostrar el mensaje si el usuario no está registrado
            function mostrarMensaje(event) {
                // Verificar si el usuario está registrado
                if (!<?php echo isset($_SESSION['username']) ? 'true' : 'false'; ?>) {
                    // Prevenir el comportamiento predeterminado del enlace
                    event.preventDefault();
                    // Mostrar el mensaje
                    alert('Debes estar registrado para poder acceder a esta sección.');
                }
            }
        });
</script>

</header>




