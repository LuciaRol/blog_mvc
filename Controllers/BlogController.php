<?php
namespace Controllers;

use Lib\Pages;
use Services\EntradasComentariosService; 
use Services\UsuariosService; 
use Services\CategoriasService;
use Models\Validacion;

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

    public function obtenerDatosBlog($error=null) {
        // Obtener todas las entradas desde el servicio
        $entradas = $this->entradasService->findAll();
        
        // Miramos si no hay entradas
        $noResults = empty($entradas);
        
         // Obtener las categorías utilizando el servicio de categorías
         $categorias = $this->categoriasService->obtenerCategorias();
        
        
        $data = ['entradas' => $entradas, 'noResults' => $noResults, 'categorias' => $categorias];

        if ($error) {
            $data['loginError'] = $error;
        }
        
        return $data;
    }
    
    
    public function mostrarBlog($error=null, $usuarioRecordado=null, $errorregistro = null) {
        // Obtener los datos para el blog
        $data = $this->obtenerDatosBlog($error);
        
        // Si hay un error, agregarlo a los datos para ser renderizado
        if ($errorregistro !== null) {
            $data['error_registro'] = $errorregistro;
        }
        
        // Instanciar la clase Pages para renderizar la vista
        $this->pagina->render("Blog/mostrarBlog", $data);   
    }

    public function buscar() {
        $searchQuery = isset($_POST['q']) ? $_POST['q'] : '';
    
        // Obtener los datos para el blog
        $data = $this->obtenerDatosBlog();
    
        // $searchquery para hacer la búsqueda
        $entradas = $this->entradasService->buscarEntradas($searchQuery);

        // Actualizar los datos con las entradas de la búsqueda y la consulta de búsqueda
        $data['entradas'] = $entradas;
        $data['searchQuery'] = $searchQuery;
        $data['noResults'] = empty($entradas);
     
    
        // Instanciar la clase Pages para renderizar la vista
        $this->pagina->render("Blog/mostrarBlog", $data);
    }

    public function buscarPorCategoria() {
        // Obtener la categoría seleccionada
        $selectedCategory = isset($_POST['categoria']) ? $_POST['categoria'] : '';
    
        // Obtener los datos para el blog
        $data = $this->obtenerDatosBlog();
    
        // Obtener todas las entradas
        $entradas = $this->entradasService->buscarPorCategoria($selectedCategory);
    
        // Si no se encontraron entradas, inicializar $entradas como un array vacío
        if ($entradas === null) {
            $entradas = [];
        }
    
        // Filtrar las entradas por la categoría seleccionada
        if (!empty($selectedCategory)) {
            $entradas = array_filter($entradas, function($entrada) use ($selectedCategory) {
                return $entrada['categoria'] === $selectedCategory;
            });
        }
    
        // Actualizar los datos con las entradas filtradas y la categoría seleccionada
        $data['entradas'] = $entradas;
        $data['selectedCategory'] = $selectedCategory;
        $data['searchQuery'] = $selectedCategory;

    
        // Si no hay resultados de búsqueda, establecer 'noResults' en true
        $data['noResults'] = empty($entradas);
    
        // Instanciar la clase Pages para renderizar la vista
        $this->pagina->render("Blog/mostrarBlog", $data);
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
            $rol = 'usur'; // Todos los usuarios son 'usur' por defecto
            
          
            // Validar y sanear los datos del usuario
            $usuarioSaneado = $this->validarSanear($username, $nombre, $apellidos, $email, $rol);
            if (!$usuarioSaneado) {
                // Si los datos no son válidos, detiene el proceso de registro
                return;
            }
    
            // Los datos saneados ahora están disponibles para su uso
            $nombre = $usuarioSaneado['nombre'];
            $apellidos = $usuarioSaneado['apellidos'];
            $email = $usuarioSaneado['email'];
            $username = $usuarioSaneado['username'];
            $rol = $usuarioSaneado['rol'];
    
            // Llama al servicio de usuarios para registrar al usuario con los datos saneados
            $usuariosService = new UsuariosService();
            $resultado = $usuariosService->register($nombre, $apellidos, $email, $username, $contrasena, $rol);
    
            // Ejecuta la función mostrarBlog()
            $this->mostrarBlog();
    
            // Sal del método registroUsuario()
            return;
        }
    }

    public function validarSanear($username, $nombre, $apellidos, $email, $rol) {
        // Validar los valores
        $errores = Validacion::validarDatosUsuario($username, $nombre, $apellidos, $email, $rol);
    
        // Si hay errores, asignar el mensaje de error a una variable
        if (!empty($errores)) {
            $this->mostrarBlog(null, null, $errores); // Pasar los errores como $errorregistro
            return false; // Indicar que hubo errores
        }
    
        // Saneamiento de los campos
        $usuarioSaneado = Validacion::sanearCamposUsuario($username, $nombre, $apellidos, $email, $rol);
       
        
        // Devolver los campos saneados
        return $usuarioSaneado;
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

    public function mostrarblogsesion($error=null) {
        // Verifica si el usuario está autenticado usando la función sesion_usuario()
        if ($this->sesion_usuario()) {
            // Si el usuario está autenticado, llama a la función mostrarBlog()
            $this->mostrarBlog();
        }
    }
 
}

