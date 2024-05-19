<?php
namespace Controllers;

use Lib\Pages;
use Services\UsuariosService;

class UsuarioController {

    private Pages $pagina;
    private UsuariosService $usuariosService;

    public function __construct()
    {
        // Crea una nueva instancia de Pages
        $this->pagina = new Pages();
        // Crea una instancia del servicio de usuarios
        $this->usuariosService = new UsuariosService();
    }

    public function mostrarUsuario($error=null) {
        // Verifica si el usuario está autenticado usando la función sesion_usuario()
        if (!$this->sesion_usuario()) {
            return;
        }
    
        // Obtén los datos del usuario autenticado
        $usuario = $this->usuariosService->obtenerUsuarioPorNombreDeUsuario($_SESSION['username']);
        
        // Obtén todas las propiedades del usuario
        $nombre = $usuario->getNombre();
        $apellidos = $usuario->getApellidos();
        $email = $usuario->getEmail();
        $username = $usuario->getUsername();
        $rol = $usuario->getRol();
    
        // Renderiza la vista de usuario pasando las propiedades del usuario
        $this->pagina->render("Blog/mostrarUsuario", compact('nombre', 'apellidos', 'email', 'username', 'rol'));
    }
    
    

    public function actualizarUsuario() {
        $username = $_POST['username'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $apellidos = $_POST['apellidos'] ?? '';
        $email = $_POST['email'] ?? '';
        $nuevoRol = $_POST['rol'] ?? '';
    
        if ($username && $nombre && $apellidos && $email && $nuevoRol) {
            $resultado = $this->usuariosService->actualizarUsuario($username, $nombre, $apellidos, $email, $nuevoRol);
            if ($resultado === null) {
                $this->mostrarUsuario(); // Redirige a mostrar usuario si la actualización es exitosa
            } else {
                // Manejo de error si ocurre algún problema al actualizar el usuario
                $this->mostrarUsuario($resultado);
            }
        } else {
            // Manejo de error si los datos del formulario no son válidos
            $this->mostrarUsuario("Datos del formulario no válidos");
        }
    }

    // Función para verificar si el usuario está autenticado
    private function sesion_usuario(): bool {
        return (new BlogController())->sesion_usuario();
    }

    // Reutilización de la función login() del BlogController
    private function login() {
        return (new BlogController())->login();
    }
}
