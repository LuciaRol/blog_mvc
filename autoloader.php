<?php
/* spl_autoload_register(function ($clase){
    $directorio_clase = str_replace('\\', '/', $clase);
    if (file_exists($directorio_clase . 'php')){
        require $directorio_clase . 'php';
    }
}); */



spl_autoload_register(function ($clase) {
    // Convertimos el nombre de la clase en una ruta de archivo
    $directorio_clase = str_replace('\\', '/', $clase);
    
    // Añadimos la extensión ".php" al final del nombre de archivo
    $archivo_clase = $directorio_clase . '.php';
    
    // Verificamos si el archivo de clase existe
    if (file_exists($archivo_clase)) {
        // Incluimos el archivo de clase
        require_once $archivo_clase;
    }
});



