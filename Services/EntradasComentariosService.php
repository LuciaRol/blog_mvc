<?php
    namespace Services;

    use Repositories\entradasComentariosRepository;
    
    class EntradasComentariosService{
        // Creando variable con
        private entradasComentariosRepository $repository;
    
        public function __construct() {
            $this->repository = new entradasComentariosRepository();
        }
    
        public function findAll(): ?array {
            // Llama al método findAll() del repositorio EntradasComentariosRepository
            return $this->repository->findAll(); // Cambiado entradasComentariosRepository a $repository
        }
        public function buscarEntradas(string $query): ?array {
            return $this->repository->buscarEntradas($query);
        }

        public function insertarEntrada($usuario_id, $categoria_id, $titulo, $descripcion, $fecha) {
            return $this->repository->insertarEntrada($usuario_id, $categoria_id, $titulo, $descripcion, $fecha);
        }
        public function editarEntrada($usuario_id, $categoria_id, $titulo, $descripcion, $fecha, $entrada_id) {
            return $this->repository->editarEntrada($usuario_id, $categoria_id, $titulo, $descripcion, $fecha, $entrada_id);
        }
        public function eliminarEntrada($entrada_id): bool {
            // Llama al método del repositorio para eliminar la entrada
            return $this->repository->eliminarEntrada($entrada_id);
        }

        public function buscarPorCategoria(string $categoria): ?array {
            // Obtener todas las entradas
            return $this->repository->obtenerentradascategoria($categoria);
    
           
    
           
        }
    }
