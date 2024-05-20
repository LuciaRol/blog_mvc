<?php
namespace Controllers;

use Lib\Pages;
use Services\UsuariosService;
use Models\Validacion;

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
    
        // Preparar los datos para renderizar la vista de usuario
        $data = compact('nombre', 'apellidos', 'email', 'username', 'rol');

        // Agregar el mensaje de error a los datos si está presente
        if ($error !== null) {
            $data['error_message'] = $error;
        }

    // Renderizar la vista de usuario pasando las propiedades del usuario y el mensaje de error si existe
    $this->pagina->render("Usuario/mostrarUsuario", $data);
    }
    
    

    // public function actualizarUsuario() {
    //     $username = $_POST['username'] ?? '';
    //     $nombre = $_POST['nombre'] ?? '';
    //     $apellidos = $_POST['apellidos'] ?? '';
    //     $email = $_POST['email'] ?? '';
    //     $nuevoRol = $_POST['rol'] ?? '';
    
    //     if ($username && $nombre && $apellidos && $email && $nuevoRol) {
    //         $resultado = $this->usuariosService->actualizarUsuario($username, $nombre, $apellidos, $email, $nuevoRol);
    //         if ($resultado === null) {
    //             $this->mostrarUsuario(); // Redirige a mostrar usuario si la actualización es exitosa
    //         } else {
    //             // Manejo de error si ocurre algún problema al actualizar el usuario
    //             $this->mostrarUsuario($resultado);
    //         }
    //     } else {
    //         // Manejo de error si los datos del formulario no son válidos
    //         $this->mostrarUsuario("Datos del formulario no válidos");
    //     }
    // }

    public function actualizarUsuario() {
        // Recibir datos del formulario
        $username = $_POST['username'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $apellidos = $_POST['apellidos'] ?? '';
        $email = $_POST['email'] ?? '';
        $nuevoRol = $_POST['rol'] ?? '';
    
        // Validar y sanear los datos
        if (!$this->validarSaneaUsuario($username, $nombre, $apellidos, $email, $nuevoRol)) {
                
            return;
        }
        else{
            // Continuar con la actualización del usuario
            $resultado = $this->usuariosService->actualizarUsuario($username, $nombre, $apellidos, $email, $nuevoRol);
            if ($resultado === null) {
                // Redirigir a mostrar usuario si la actualización es exitosa
                $this->mostrarUsuario();
            } else {
                // Manejo de error si ocurre algún problema al actualizar el usuario
                $this->mostrarUsuario($resultado);
            }
        }
    }


    private function validarSaneaUsuario($username, $nombre, $apellidos, $email, $rol) {
        // Validar los valores
        $errores = Validacion::validarDatosUsuario($username, $nombre, $apellidos, $email, $rol);
    
        // Si hay errores, asignar el mensaje de error a una variable
        if (!empty($errores)) {
            $this->mostrarUsuario($errores);
            // Renderiza la vista de usuario pasando las propiedades del usuario
           

            return false; // Indicar que hubo errores
        }
    
        // Saneamiento de los campos
        $usuarioSaneado = Validacion::sanearCamposUsuario($username, $nombre, $apellidos, $email, $rol);
        
        // Asignar los valores saneados de vuelta a las variables originales
        $username = $usuarioSaneado['username'];
        $nombre = $usuarioSaneado['nombre'];
        $apellidos = $usuarioSaneado['apellidos'];
        $email = $usuarioSaneado['email'];
        $rol = $usuarioSaneado['rol'];
    
        return true; // Indicar que los campos son válidos y saneados correctamente
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
