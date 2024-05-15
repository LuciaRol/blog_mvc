<?php
namespace Controllers;

use Lib\Pages;
use Services\EntradasComentariosService; // Importa el servicio de entradas
use Models\Blog;

class BlogController {

    private Pages $pagina;
    private EntradasComentariosService $entradasService; // Cambia el nombre del servicio

    public function __construct()
    {
        // Crea una nueva instancia de Pages
        $this->pagina = new Pages();
        // Crea una instancia del servicio de entradas
        $this->entradasService = new EntradasComentariosService();
    }

    public function mostrarBlog() {
        // Obtén todas las entradas desde el servicio
        //$entradas = $this->entradasService->findAll();

        // Aquí puedes utilizar las entradas obtenidas para mostrarlas en la página
        // Por ejemplo, podrías iterar sobre $entradas y mostrar los detalles de cada entrada
        // echo "<h1>Entradas</h1>";
        // echo "<ul>";
        // foreach ($entradas as $entrada) {
        //     echo "<li>" . 
        //          "Usuario ID: " . $entrada['titulo'] . ", " . 
        //          "Categoría ID: " . $entrada['descripcion'] . ", " . 
        //          "Título: " . $entrada['nombre'] . ", " . 
        //          "Descripción: " . $entrada['apellidos'] . ", " . 
        //          "Fecha: " . $entrada['email'] . 
        //          "Fecha: " . $entrada['username'] . 
        //          "Fecha: " . $entrada['rol'] . 
        //          "Fecha: " . $entrada['categoria'] . 
        //          "</li>";
        // }
        // echo "</ul>";
        // Puedes continuar agregando más lógica para mostrar el contenido del blog aquí


        // Instanciar la clase Pages para renderizar la vista
        $this->pagina->render("Blog/mostrarBlog");
    }

    // Puedes agregar más métodos del controlador según sea necesario
}

