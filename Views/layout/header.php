
<header class="header">
    <div class="header_first_div">
        <div class="header_principal">
            <div ><img class="principal_logo" src="Assets/img/nebulosa.png" alt=""></div>
            <h1 class="principal_title">Blog</h1>
        </div>
        <nav class="nav_container">
            <a class="nav_link" href="">Inicio</a>
            <a class="nav_link" href="">Enlace 1</a>
            <a class="nav_link" href="">Enlace 2</a>
            <a class="nav_link" href="">Enlace 3</a>
            <a class="nav_link" href="">Contacto</a>
        </nav>
    </div>

    <div class="header_second_div">
        <div class="search_container">
            <form action="<?= BASE_URL ?>?controller=Blog&action=buscar" method="POST">
                <label class="search_label" for="buscar">Buscar</label>
                <input class="search_input" type="text" name="q" placeholder="Busca">
                <button type="submit" class="search_button">Buscar</button>
            </form>
            <form action="<?= BASE_URL ?>?controller=Blog&action=mostrarBlog" method="POST">
                <button type="submit" class="search_button">Borrar Búsqueda</button>
            </form>
        </div>
        

        <div class="login_container">
            <input class="login_user" type="text" placeholder="Usuario">
            <input class="login_pass" type="text" placeholder="Contraseña">
            <button class="login_btn" for="login">Iniciar sesión</button>
        </div>
    </div>
</header>

