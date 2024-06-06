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

    public function mostrarUsuario($error=null):void {
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
        
        if ($rol == 'admin'){

            $usuarios = $this->usuariosService->obtenerUsuarios();
            $data['usuarios'] = $usuarios;
        }


    // Renderizar la vista de usuario pasando las propiedades del usuario y el mensaje de error si existe
    $this->pagina->render("Usuario/mostrarUsuario", $data);
    }

    public function obtenerUsuarios(): array|null{
        return $usuarios = $this->usuariosService->obtenerUsuarios();

    }

    public function actualizarUsuario():void {
        // Recibir datos del formulario
        $username = $_POST['username'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $apellidos = $_POST['apellidos'] ?? '';
        $email = $_POST['email'] ?? '';
        $nuevoRol = $_POST['rol'] ?? 'usur'; // Asignar 'usur' como valor predeterminado si $nuevoRol es nulo
    
        // Validar y sanear los datos
        $usuarioValidado = $this->validarSaneaUsuario($username, $nombre, $apellidos, $email, $nuevoRol);
        if (!$usuarioValidado) {
            return;
        }

        // Continuar con la actualización del usuario utilizando los campos saneados
        $resultado = $this->usuariosService->actualizarUsuario(
            $usuarioValidado['username'],
            $usuarioValidado['nombre'],
            $usuarioValidado['apellidos'],
            $usuarioValidado['email'],
            $usuarioValidado['rol']
        );
            if ($resultado === null) {
                // Redirigir a mostrar usuario si la actualización es exitosa
                $this->mostrarUsuario();
            } else {
                // Manejo de error si ocurre algún problema al actualizar el usuario
                $this->mostrarUsuario($resultado);
            }
        }
    


    public function validarSaneaUsuario($username, $nombre, $apellidos, $email, $rol):array|bool {
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
        // Saneamiento de los campos
        $usuarioSaneado = Validacion::sanearCamposUsuario($username, $nombre, $apellidos, $email, $rol);
        
        // Devolver los campos saneados
        return $usuarioSaneado;
    }

    // Función para verificar si el usuario está autenticado
    public function sesion_usuario(): bool {
        return (new BlogController())->sesion_usuario();
    }

    // Reutilización de la función login() del BlogController
    public function login():void {
        (new BlogController())->login();
    }
}
