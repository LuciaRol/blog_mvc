<?php

namespace Controllers;

use Lib\Pages;
use Services\UsuariosService;
use Services\EntradasComentariosService;
use Services\CategoriasService;
use Models\Validacion;

class EntradaController {

    private Pages $pagina;
    private UsuariosService $usuariosService;
    private EntradasComentariosService $entradasService;
    private CategoriasService $categoriasService;

    public function __construct()
    {
        // Crea una nueva instancia de Pages
        $this->pagina = new Pages();
        // Inicializa los servicios necesarios
        $this->usuariosService = new UsuariosService();
        $this->entradasService = new EntradasComentariosService();
        $this->categoriasService = new CategoriasService();
    }

    // Función para mostrar las entradas del blog
    public function mostrarEntradas($error=null) {
        // Verifica si el usuario está autenticado
        if (!$this->sesion_usuario()) {
            return;
        }
        $usuario = $this->usuariosService->obtenerUsuarioPorNombreDeUsuario($_SESSION['username']);
        $usuario_id = $usuario->getId();
        // Procesa el formulario de creación o edición de entradas
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titulo']) && isset($_POST['descripcion']) && isset($_POST['categoria'])) {
            // Obtener el ID del usuario de la sesión
            
            // Obtener datos del formulario
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
            $categoria_id = $_POST['categoria'];
            $fecha = date('Y-m-d'); // Fecha actual
    
            // Validar y sanear los valores
            if (!$this->validasanea($titulo, $descripcion, $categoria_id, $fecha)) {
                return; // Si hubo errores, terminar la ejecución de la función
            }
    
            // Determinar si se está editando o creando una entrada nueva
            if (isset($_POST['entrada_id'])) {
                // Editar la entrada existente
                $this->entradasService->editarEntrada($usuario_id, $categoria_id, $titulo, $descripcion, $fecha, $_POST['entrada_id']);
            } else {
                // Insertar nueva entrada
                $this->entradasService->insertarEntrada($usuario_id, $categoria_id, $titulo, $descripcion, $fecha);
            }
        }
    
        // Obtener los datos del blog
        $data = $this->obtenerDatosEntradas($error, $usuario_id);
    
        // Renderizar la vista mostrando las entradas
        $this->pagina->render("Blog/mostrarEntradas", $data);
    }
    
    private function validasanea(&$titulo, &$descripcion, &$categoria_id, &$fecha) {
        // Validar los valores
        $errores = Validacion::validar($titulo, $descripcion, $categoria_id, $fecha);
        if (!empty($errores)) {
            // Si hay errores, asignar el mensaje de error a una variable
            $error_message = "Los campos están vacíos.";
            
            // Obtener los datos del blog
            $data = $this->obtenerDatosEntradas();

            // Agregar el mensaje de error a los datos
            $data['error_message'] = $error_message;
    
            // Renderizar la vista mostrando el mensaje de error y los datos de las entradas
            $this->pagina->render("Blog/mostrarEntradas", $data);
            
            return false; // Indicar que hubo errores
        }
        
        // Saneamos los campos
        $campos_saneados = Validacion::sanearCampos($titulo, $descripcion, $categoria_id, $fecha);
        $titulo = $campos_saneados['titulo'];
        $descripcion = $campos_saneados['descripcion'];
        $categoria_id = $campos_saneados['categoria'];
        $fecha = $campos_saneados['fecha'];
    
        return true; // Indicar que la validación y el saneamiento fueron exitosos
    }

    public function obtenerDatosEntradas($error=null, $usuario_id=null) {
        // Obtener todas las entradas desde el servicio
        $entradas = $this->entradasService->findEntradasUser($usuario_id);
        
        // Miramos si no hay entradas
        $noResults = empty($entradas);
        
        // Obtener las categorías utilizando el servicio de categorías
        $categorias = $this->categoriasService->obtenerCategorias();
        
        $data = [
            'categorias' => $categorias,
            'entradas' => $entradas,
            'noResults' => $noResults
        ];
        
        if ($error) {
            $data['loginError'] = $error;
        }
        
        return $data;
    }
    // Función para eliminar una entrada del blog
    public function eliminarEntrada() {
        // Verificar si se recibió un ID de entrada válido
        if (isset($_POST['entrada_id'])) {
            $entrada_id = $_POST['entrada_id'];

            // Intentar eliminar la entrada utilizando el servicio correspondiente
            $resultado = $this->entradasService->eliminarEntrada($entrada_id);

            // Redirigir a mostrarEntradas() independientemente del resultado de la eliminación
            $this->mostrarEntradas();
        } else {
            // Manejar el caso en que no se proporciona un ID de entrada válido
            echo "ID de entrada no válido";
        }
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
