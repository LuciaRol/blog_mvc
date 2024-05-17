<?php
    namespace Repositories;
    use Lib\DataBase;
    use Models\Usuarios;
    use DateTime;
    use PDOException;
    use PDO;
    class UsuariosRepository{
        private DataBase $conection;
        private mixed $sql;
        function __construct(){
            $this->conection = new DataBase();
        }
        public function findAll():? array {
            $this->conection->querySQL("SELECT * FROM usuarios;");
            return $this->extractAll();
        }
        public function extractAll():?array {
            $usuarios = [];
            try{
                $this->conection->querySQL("SELECT * FROM usuarios");
                $usuariosData = $this->conection->allRegister();
                foreach ($usuariosData as $usuarioData){
                    $usuarios[]=Usuarios::fromArray($usuarioData);
                }
            }catch(PDOException){
                $usuarios=null;
            }
            return $usuarios;
        }
        public function registro($nombre, $apellidos, $email, $username, $contrasena, $rol): ?string {
            try {
                // Prepara y ejecuta la consulta SQL para insertar el usuario en la base de datos
                $this->sql = $this->conection->prepareSQL("INSERT INTO usuarios (nombre, apellidos, email, username, contrasena, rol) VALUES (:nombre, :apellidos, :email, :username, :contrasena, :rol);");
                $this->sql->bindValue(":nombre", "$nombre", PDO::PARAM_STR);
                $this->sql->bindValue(":apellidos", $apellidos, PDO::PARAM_STR);
                $this->sql->bindValue(":email", $email, PDO::PARAM_STR);
                $this->sql->bindValue(":username", $username, PDO::PARAM_STR);
                $this->sql->bindValue(":contrasena", $contrasena, PDO::PARAM_STR);
                $this->sql->bindValue(":rol", $rol, PDO::PARAM_STR);
                $this->sql->execute();
                $this->sql->closeCursor();
                $resultado = null;
            } catch (PDOException $e) {
                $resultado = $e->getMessage();
            }
            return $resultado;
        }

        
    }