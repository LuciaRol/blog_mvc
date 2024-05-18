<?php
    namespace Services;
    use Repositories\categoriasRepository;
    class CategoriasService{
        
        private CategoriasRepository $categoriasRepository;
        function __construct() {
            $this->categoriasRepository = new CategoriasRepository();
        }

        public function obtenercategorias() :?array {
            return $this->categoriasRepository->findAll();
        }
        
    }