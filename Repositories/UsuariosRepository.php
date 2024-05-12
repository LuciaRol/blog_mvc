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
        public function registro($nombre,$apellidos,$email, $username, $contrasena, $rol):?string{
            try{
                $this->sql = $this->conection->prepareSQL("INSERT INTO usuarios(nombre, apellidos, email, username, contrasena, rol) VALUES (:nombre, :apellidos, :email, :username, :contrasena, :rol);");
                $rol = "user";
                $this->sql->bindValue(":nombre",$nombre);
                $this->sql->bindValue(":apellidos",$apellidos);
                $this->sql->bindValue(":email",$email);
                $this->sql->bindValue(":username",$username);
                $this->sql->bindValue(":contrasena",$contrasena);
                $this->sql->bindValue(":rol",$rol);
                $this->sql->execute();
                $this->sql->closeCursor();
                $this->sql = null;
                
            }catch(PDOException $e){
                $result = $e->getMessage();
            }
            return $result;
        }
        public function getIdentity($email) {
            $usuario = null;
            try {
                $this->sql = $this->conection->prepareSQL("SELECT * FROM usuarios WHERE email = :email");
                $this->sql->bindValue(":email", $email);
                $this->sql->execute();
                $usuarioData = $this->sql->fetch(PDO::FETCH_ASSOC);
                $this->sql->closeCursor();
                $usuario = $usuarioData ?: null;
                
            } catch (PDOException $e) {
                $usuario = $e->getMessage();
            }
            return $usuario;
        }
        public function getIdentityId($id) {
            $usuario = null;
            try {
                $this->sql = $this->conection->prepareSQL("SELECT * FROM usuarios WHERE id = :id");
                $this->sql->bindValue(":id", $id);
                $this->sql->execute();
                $usuarioData = $this->sql->fetch(PDO::FETCH_ASSOC);
                $this->sql->closeCursor();
                $usuario = $usuarioData ?: null;
                
            } catch (PDOException $e) {
                $usuario = $e->getMessage();
            }
            return $usuario;
        }
        public function removeUser($id):?string {
            try{
                $this->sql = $this->conection->prepareSQL("DELETE FROM usuarios WHERE id = :id;");
                $this->sql->bindValue(":id",$id);
                $this->sql->execute();
                $result = null;
            }catch(PDOException $e){
                $result = $e->getMessage();
            }
            $this->sql->closeCursor();
            $this->sql = null;
            return $result;
        }
        public function update($id,$rol) :?string {
            $result = "";
            try{
                $this->sql = $this->conection->prepareSQL("UPDATE usuarios SET rol=:rol WHERE id = :id;");
                $this->sql->bindValue(":id",$id);
                $this->sql->bindValue(":rol",$rol);
                $this->sql->execute();
                $result = null;
            }catch(PDOException $e){
                $result = $e->getMessage();
            }
            $this->sql->closeCursor();
            $this->sql = null;
            return $result;
        }
        public function addCommit($id,$date) :?string {
            $result = "";
            try{
                $this->sql = $this->conection->prepareSQL("UPDATE usuarios SET ultimo_Commit=:fecha WHERE id = :id;");
                $this->sql->bindValue(":id",$id);
                $this->sql->bindValue(":fecha",$date);
                $this->sql->execute();
                $result = null;
            }catch(PDOException $e){
                $result = $e->getMessage();
            }
            $this->sql->closeCursor();
            $this->sql = null;
            return $result;
        }
    }