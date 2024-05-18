<?php
namespace Controllers;

use Lib\Pages;
use Services\EntradasComentariosService; 
use Services\UsuariosService; 
use Models\Blog;
use Models\Usuarios;

class BlogController {

    private Pages $pagina;  
    private EntradasComentariosService $entradasService; 
    private UsuariosService $usuariosService;


    public function __construct()
    {
        // Crea una nueva instancia de Pages
        $this->pagina = new Pages();
        // Crea una instancia del servicio de entradas
        $this->entradasService = new EntradasComentariosService();

        $this->usuariosService = new UsuariosService();

    }

    public function mostrarBlog($error=null) {
            
        // Obtener todas las entradas desde el servicio
        $entradas = $this->entradasService->findAll();

        // Miramos si no hay entradas
        $noResults = empty($entradas);

        $data = ['entradas' => $entradas, 'noResults' => $noResults];

        if ($error) {
            $data['loginError'] = $error;
        }
    

        // Instanciar la clase Pages para renderizar la vista
        $this->pagina->render("Blog/mostrarBlog", $data);   
    }

    public function buscar() {
        $searchQuery = isset($_POST['q']) ? $_POST['q'] : '';

        #$searchQuery = 'Introducción';
        // $searchquery para hacer la búsqueda
        $entradas = $this->entradasService->buscarEntradas($searchQuery);

        // Miramos si no hay entradas
        $noResults = empty($entradas);
    
        // Instanciar la clase Pages para renderizar la vista
        $this->pagina->render("Blog/mostrarBlog", ['entradas' => $entradas, 'searchQuery' => $searchQuery, 'noResults' => $noResults]);
    }

    public function registroUsuario() {
        // Verifica si se ha enviado el formulario de registro
        if (isset($_POST['registro'])) {
            // Obtiene los datos del formulario
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $email = $_POST['email'];
            $username = $_POST['username'];
            $contrasena = $_POST['contrasena'];
            $rol = 'usur'; // Todos los usuarios son usur por defecto

            // Llama al servicio de usuarios para registrar al usuario
            $usuariosService = new UsuariosService();

            
            $resultado = $usuariosService->register($nombre, $apellidos, $email, $username, $contrasena, $rol);
            
            // Ejecuta la función mostrarBlog()
            $this->mostrarBlog();

            // Sal del método registroUsuario()
            return;
        
            }
    }
    public function login() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $error = ''; //Creamos esta variable para que si todo va bien, no de error al mostrarBlog

    if ($username && $password) {
        $user = $this->usuariosService->verificaCredenciales($username, $password);
        if ($user) {
            session_start();
            $_SESSION['username'] = $user->getUsername();
            
        } else {
            $error = 'Usuario o contraseña incorrecta';
        }
    } 

    // Aquí hay que empezar un new usuario
    // else {
    //     $error = 'Complete todos los campos';
    // } comentado debido al error que muestra sesion_usuario

    $this->mostrarBlog($error); // Llama a mostrarBlog con el posible mensaje de error del login
    
}

    public function logout() {
        session_start();
        session_destroy();
        $this->mostrarBlog(); // vuelve al origen y cierra la sesion. No puede cerrar sesion estando en otras instancias dado que no debería tener acceso
    }

    public function sesion_usuario():bool {
        // Verifica si hay una sesión iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    
        // Verifica si el usuario está autenticado
        if (!isset($_SESSION['username'])) {
            // Si el usuario no está autenticado, redirige al método de login
            $this->login();
            return false;
        }
    
        return true; // Retorna true si el usuario está autenticado
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
    
    public function mostrarCategoria2($error=null) {

         // Verifica si el usuario está autenticado usando la función sesion_usuario()
         if (!$this->sesion_usuario()) {
            
         }
     
         // Renderiza la vista de la categoría
        
        $this->pagina->render("Blog/mostrarCategoria2");   
    }

    public function mostrarblogsesion($error=null) {
        // Verifica si el usuario está autenticado usando la función sesion_usuario()
        if ($this->sesion_usuario()) {
            // Si el usuario está autenticado, llama a la función mostrarBlog()
            $this->mostrarBlog();
        }
    }

    public function actualizarRol() {
        $username = $_POST['username'] ?? '';
        $nuevoRol = $_POST['rol'] ?? '';

        if ($username && $nuevoRol) {
            $resultado = $this->usuariosService->actualizarRol($username, $nuevoRol);
            if ($resultado === null) {
                $this->mostrarUsuario(); // Redirige a mostrar usuario si la actualización es exitosa
            } else {
                // Manejo de error si ocurre algún problema al actualizar el rol
                $this->mostrarUsuario($resultado);
            }
        } else {
            // Manejo de error si los datos del formulario no son válidos
            $this->mostrarUsuario("Datos del formulario no válidos");
        }
    }

}

