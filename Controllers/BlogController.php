<?php
namespace Controllers;

use Lib\Pages;
use Services\EntradasComentariosService; 
use Services\UsuariosService; 
use Services\CategoriasService;


class BlogController {

    private Pages $pagina;  
    private EntradasComentariosService $entradasService; 
    private UsuariosService $usuariosService;

    private CategoriasService $categoriasService;


    public function __construct()
    {
        // Crea una nueva instancia de Pages
        $this->pagina = new Pages();
        // Crea una instancia del servicio de entradas
        $this->entradasService = new EntradasComentariosService();

        $this->usuariosService = new UsuariosService();

        $this->categoriasService = new CategoriasService();

    }

    public function mostrarBlog($error=null, $usuarioRecordado=null) {
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
    // USUARIO
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
        $error = ''; // Creamos esta variable para que si todo va bien, no de error al mostrarBlog
    
        if ($username && $password) {
            $user = $this->usuariosService->verificaCredenciales($username, $password);
            if ($user) {
                session_start();
                $_SESSION['username'] = $user->getUsername();
                
                // Si se marca la casilla de "recordar usuario", establecer la cookie
                
                // Establecer el nombre de usuario como valor de la cookie
                setcookie("usuario_recordado", $user->getUsername(), time() + (30 * 24 * 60 * 60), "/");
                
                
            } else {
                $error = 'Usuario o contraseña incorrecta';
            }
        } 
    
        // Verificar si la cookie "usuario_recordado" existe y establecer la variable $usuarioRecordado
        $usuarioRecordado = isset($_COOKIE['usuario_recordado']) ? $_COOKIE['usuario_recordado'] : null;
    
        // Llama a mostrarBlog con el posible mensaje de error del login y la variable $usuarioRecordado
        $this->mostrarBlog($error, $usuarioRecordado);
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
    
   
    public function mostrarblogsesion($error=null) {
        // Verifica si el usuario está autenticado usando la función sesion_usuario()
        if ($this->sesion_usuario()) {
            // Si el usuario está autenticado, llama a la función mostrarBlog()
            $this->mostrarBlog();
        }
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
    // CATEGORIAS
    public function mostrarCategorias($error=null) {
        // Verifica si el usuario está autenticado usando la función sesion_usuario()
        if (!$this->sesion_usuario()) {
            return;
        }
    
        // Obtén los datos de las categorías usando el servicio de categorías
        $categorias = $this->categoriasService->obtenerCategorias();
        
        // Renderiza la vista de categorías pasando los datos obtenidos
        $this->pagina->render("Blog/mostrarCategorias", ['categorias' => $categorias]);   
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

    // Entradas
    public function mostrarEntradas($error=null) {
        if (!$this->sesion_usuario()) {
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titulo']) && isset($_POST['descripcion']) && isset($_POST['categoria'])) {
            // Obtener usuario ID de la sesión
            // $usuario_id = $_SESSION['id'];
            $usuario = $this->usuariosService->obtenerUsuarioPorNombreDeUsuario($_SESSION['username']);

            $usuario_id = $usuario->getId();
            // Obtener datos del formulario
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
            $categoria_id = $_POST['categoria'];
            $fecha = date('Y-m-d'); // Fecha actual
    
            // Insertar nueva entrada
            $this->insertarEntrada($usuario_id, $categoria_id, $titulo, $descripcion, $fecha);
        }
    
        // Obtén las categorías utilizando el servicio de categorías
        $categorias = $this->categoriasService->obtenerCategorias();
    
        // Pasar las categorías a la vista
        $data = ['categorias' => $categorias];
    
        // Renderiza la vista de entradas pasando los datos obtenidos
        $this->pagina->render("Blog/mostrarEntradas", $data);
    }
    
    private function insertarEntrada($usuario_id, $categoria_id, $titulo, $descripcion, $fecha) {
        // Llama al método del servicio para insertar la entrada
        $resultado = $this->entradasService->insertarEntrada($usuario_id, $categoria_id, $titulo, $descripcion, $fecha);
        if ($resultado) {
            // Entrada insertada correctamente
            // Redirige a alguna página de éxito o muestra un mensaje
        } else {
            // Error al insertar la entrada
            // Maneja el error adecuadamente
        }
    }


}

