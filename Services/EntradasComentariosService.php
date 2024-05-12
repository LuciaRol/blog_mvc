<?php
    namespace Services;

    use Repositories\entradasComentariosRepository;
    
    class EntradasComentariosService{
        // Creando variable con
        private entradasComentariosRepository $repository;
    
        public function __construct() {
            $this->repository = new entradasComentariosRepository();
        }
    
        public function addCommit(array $data):void {
            $this->repository->addCommit($data);
        }
    
        public function delete($id):void {
            $this->repository->delete($id);
        }
    
        public function findAll(): ?array {
            // Llama al método findAll() del repositorio EntradasComentariosRepository
            return $this->repository->findAll(); // Cambiado entradasComentariosRepository a $repository
        }
    }
?>