<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monedero en MVC</title>
    <link rel="stylesheet" href="Assets/css/styles.css">
</head>
<body>
    <?php
        require_once 'autoloader.php';
        require_once 'Config/Config.php';

        use Controllers\FrontController;
        FrontController::main();
    ?>
    

</body>
</html>