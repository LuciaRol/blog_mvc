<?php
    namespace Services;
    use Repositories\entradasRepository;
    class RutasService{
        // Creando variable con
        private entradasRepository $repository;
        function __construct() {
            $this->repository = new entradasRepository();
        }

        public function allRutas() :?array {
            return $this->repository->findAll();
        }
        public function addCategoria($data) :void {
            $this->repository->addCategoria($data);
        }
        public function countRutas() :?int {
            return $this->repository->countCategorias();
        }
        
        public function delete($id):? string {
            return $this->repository->delete($id);
        }
        public function getData($id) {
            return $this->repository->getData($id);
        }
        public function edit(array $data) {
            $this->repository->edit($data);
        }
        public function buscar($opt, $search) :?array {
            return $this->repository->search($opt,$search);
        }
    }