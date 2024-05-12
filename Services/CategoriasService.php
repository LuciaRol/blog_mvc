<?php
    namespace Services;
    use Repositories\categoriasRepository;
    class CategoriasService{
        // Creando variable con
        private categoriasRepository $repository;
        function __construct() {
            $this->repository = new categoriasRepository();
        }

        public function allCategorias() :?array {
            return $this->repository->findAll();
        }
        public function addCategoria($data) :void {
            $this->repository->addCategoria($data);
        }
        public function countCategorias() :?int {
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