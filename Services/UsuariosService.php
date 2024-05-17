<?php
    namespace Services;
    use Repositories\UsuariosRepository;
    class UsuariosService{
        // Creando variable con
        private UsuariosRepository $userRepository;
        function __construct() {
            $this->userRepository = new UsuariosRepository();
        }
        public function allUsers() :?array {
            return $this->userRepository->findAll();
        }
       
        public function register($nombre, $apellidos, $email, $username, $contrasena, $rol): ?string {
            // Llama al método del repositorio para insertar el usuario en la base de datos
            return $this->userRepository->registro($nombre, $apellidos, $email, $username, $contrasena, $rol);
        }
    }