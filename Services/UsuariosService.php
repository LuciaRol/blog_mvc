<?php
    namespace Services;
    use Repositories\UsuariosRepository;
    use Models\Usuarios;
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

        public function verificaCredenciales(string $username, string $password): ?Usuarios {
            $user = $this->userRepository->findByUsername($username);
            
            // Verifica que el usuario exista y que la contraseña coincida
            if ($user && password_verify($password, $user->getContrasena())) {
                return $user; // Devuelve el objeto Usuarios si las credenciales son correctas
            } else {
                return null; // Devuelve null si las credenciales son incorrectas
            }
        }

        public function obtenerUsuarioPorNombreDeUsuario(string $username): ?Usuarios {
            return $this->userRepository->findByUsername($username);
        }

    }