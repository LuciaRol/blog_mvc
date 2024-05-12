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
        public function register($nombre,$apellidos,$email, $username, $contrasena, $rol):?string{
            return $this->userRepository->registro($nombre,$apellidos,$email, $username, $contrasena, $rol);
        }
        public function getIdentity($email) {
            return $this->userRepository->getIdentity($email);
        }
        public function getData($id) {
            return $this->userRepository->getIdentityId($id);
        }
        public function removeUser($id):?string {
            return $this->userRepository->removeUser($id);
        }
        public function update($id,$rol) :?string {
            return  $this->userRepository->update($id,$rol);
        }
        public function addCommit($id,$date) :?string {
            return $this->userRepository->addCommit($id,$date);
        }
    }