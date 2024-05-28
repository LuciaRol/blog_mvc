<?php

namespace Controllers;

use Lib\Pages;
use Services\CategoriasService;
use Services\UsuariosService;

class CategoriaController {

    private Pages $pagina;
    private CategoriasService $categoriasService;
    private UsuariosService $usuariosService;

    public function __construct()
    {
        // Crea una nueva instancia de Pages
        $this->pagina = new Pages();
        // Crea una instancia del servicio de categorías
        $this->categoriasService = new CategoriasService();
        // Crea una instancia del servicio de usuarios
        $this->usuariosService = new UsuariosService();
    }

    public function mostrarCategorias($error = null) {
        // Verifica si el usuario está autenticado 
        if (!$this->sesion_usuario()) {
            return;
        }

        // obtiene el usuario que está logeado actualmente y su rol
        $usuario = $this->usuariosService->obtenerUsuarioPorNombreDeUsuario($_SESSION['username']);
        $esAdmin = ($usuario && $usuario->getRol() === 'admin');

        // Obtén los datos de las categorías usando el servicio de categorías
        $categorias = $this->categoriasService->obtenerCategorias();
        
        $this->pagina->render("Blog/mostrarCategorias", [
            'categorias' => $categorias,
            'esAdmin' => $esAdmin,
            'mensaje' => $error
        ]);
    }

    public function registroCategoria() {
        $mensaje = ''; // Inicializamos la variable de mensaje
        
        // Verifica si el usuario está autenticado
        if ($this->sesion_usuario()) {
            // Obtén el usuario actual
            $usuario = $this->usuariosService->obtenerUsuarioPorNombreDeUsuario($_SESSION['username']);
            
            // Verifica si el usuario tiene permisos de administrador
            if ($usuario->getRol() === 'admin') {
                // Después de verificar al usuario como administrador, guarda la nueva categoría si está presente en el formulario
                if (isset($_POST['nueva_categoria'])) {
                    $nombreCategoria = $_POST['nueva_categoria'];
                    $this->categoriasService->guardarCategoria($nombreCategoria);
                }
            } else {
                // Si el usuario no es administrador, asigna un mensaje indicando que no tiene permisos suficientes
                $mensaje = "No tienes permisos de administrador para registrar nuevas categorías.";
            }
        }
        
        // Obtener las categorías para mostrar en la vista
        $categorias = $this->categoriasService->obtenerCategorias();
        
        // Pasar las categorías y el mensaje a la vista
        $data = ['categorias' => $categorias, 'mensaje' => $mensaje];
        
        // Renderizar la vista
        $this->pagina->render("Blog/mostrarCategorias", $data);
    }

    // Reutilización de la función sesion_usuario() del BlogController
    private function sesion_usuario(): bool {
        return (new BlogController())->sesion_usuario();
    }

    // Reutilización de la función login() del BlogController
    private function login() {
        return (new BlogController())->login();
    }
}
