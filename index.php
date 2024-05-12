<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog en MVC</title>
    <link rel="stylesheet" href="Assets/css/styles.css">
</head>
<body>
    <?php
        require_once 'autoloader.php';
        require_once 'Config/Config.php';
        require_once __DIR__ . '/vendor/autoload.php';

        // Cargamos el .env donde se almacenan de forma segura los usuarios y contraseña de bbdd
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
        
        use Controllers\FrontController;
        FrontController::main();
    ?>
    

</body>
</html>