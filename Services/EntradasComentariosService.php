<?php
    namespace Services;
    use Repositories\entradasComentariosRepository;
    class RutasComentariosService{
        // Creando variable con
        private entradasComentariosRepository $repository;
        function __construct() {
            $this->repository = new entradasComentariosRepository();
        }
        public function searchRutaId($id) {
            return $this->repository->findAll($id);
        }
        public function addCommit(array $data):void {
            $this->repository->addCommit($data);
        }
        public function delete($id):void {
            $this->repository->delete($id);
        }
    }