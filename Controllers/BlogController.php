<?php
namespace Controllers;

use Lib\Pages;
use Services\EntradasComentariosService; // Importa el servicio de entradas
use Models\Blog;

class BlogController {
    private EntradasComentariosService $entradasComentariosService;

    private Pages $pagina;
    private EntradasComentariosService $entradasService; 

    public function __construct()
    {
        // Crea una nueva instancia de Pages
        $this->pagina = new Pages();
        // Crea una instancia del servicio de entradas
        $this->entradasService = new EntradasComentariosService();
    }

    public function mostrarBlog() {
            
        // Obtener todas las entradas desde el servicio
        $entradas = $this->entradasService->findAll();

        // Instanciar la clase Pages para renderizar la vista
        $this->pagina->render("Blog/mostrarBlog", ['entradas' => $entradas]);
   
    }
    public function buscar() {
        $searchQuery = isset($_POST['q']) ? $_POST['q'] : '';

        #$searchQuery = 'Introducción';
        // Use $searchQuery to perform the search
        $entradas = $this->entradasService->buscarEntradas($searchQuery);
    
        // Instanciar la clase Pages para renderizar la vista
        $this->pagina->render("Blog/mostrarBlog", ['entradas' => $entradas]);
    }
   
}

