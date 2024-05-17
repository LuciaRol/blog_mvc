<?php
    namespace Repositories;
    use Lib\DataBase;
    use PDOException;
    use PDO;
    class entradasComentariosRepository{
        private DataBase $conection;
        private mixed $sql;
        function __construct(){
            $this->conection = new DataBase();
        }
        public function findAll() {
            $entradaCommit = null;
            try {
                $this->sql = $this->conection->prepareSQL("SELECT   	
                                                                entradas.titulo,
                                                                entradas.descripcion,
                                                                entradas.fecha,
                                                                usuarios.nombre,
                                                                usuarios.apellidos,
                                                                usuarios.email,
                                                                usuarios.username,	
                                                                usuarios.rol,
                                                                categorias.nombre as categoria
                                                            FROM entradas 
                                                            inner join usuarios
                                                            on usuarios.id = entradas.usuario_id
                                                            inner join categorias
                                                            on categorias.id = entradas.categoria_id");
                
                $this->sql->execute();
                $entradaCommitData = $this->sql->fetchAll(PDO::FETCH_ASSOC);
                $this->sql->closeCursor();
                $entradaCommit = $entradaCommitData ?: null;
                
            } catch (PDOException $e) {
                $entradaCommit = $e->getMessage();
            }
        
            return $entradaCommit;
        }
        public function addCommit(array $data):?string {
            try{
                $this->sql = $this->conection->prepareSQL("INSERT INTO entradas(usuario_id,categoria_id,titulo,descripcion,fecha) VALUES (:usuario_id,:categoria_id,:titulo,:descripcion,:fecha);");
                $this->sql->bindValue(":usuario_id",$data['usuario_id']);
                $this->sql->bindValue(":categoria_id",$data['categoria_id']);
                $this->sql->bindValue(":titulo",$data['titulo']);
                $this->sql->bindValue(":descripcion",$data['descripcion']);
                $this->sql->bindValue(":fecha",$data['fecha']);
                $this->sql->execute();
                $result = null;
            }catch(PDOException $e){
                $result = $e->getMessage();
            }
            $this->sql->closeCursor();
            $this->sql = null;
            return $result;
        }
        public function delete($id):?string {
            try{
                $this->sql = $this->conection->prepareSQL("DELETE FROM entradas WHERE id = :id;");
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


        public function buscarEntradas(string $query): ?array {
            $query = '%' . $query . '%';
            $entradaCommit = null;
            try {
                $this->sql = $this->conection->prepareSQL("SELECT   	
                                                                entradas.titulo,
                                                                entradas.descripcion,
                                                                entradas.fecha,
                                                                usuarios.nombre,
                                                                usuarios.apellidos,
                                                                usuarios.email,
                                                                usuarios.username,	
                                                                usuarios.rol,
                                                                categorias.nombre as categoria
                                                            FROM entradas 
                                                            inner join usuarios
                                                            on usuarios.id = entradas.usuario_id
                                                            inner join categorias
                                                            on categorias.id = entradas.categoria_id
                                                            WHERE titulo LIKE :query OR descripcion LIKE :query");
                $this->sql->bindValue(':query', $query, PDO::PARAM_STR);
                $this->sql->execute();
                $entradaCommitData = $this->sql->fetchAll(PDO::FETCH_ASSOC);
                $this->sql->closeCursor();
                $entradaCommit = $entradaCommitData ?: null;
                
            } catch (PDOException $e) {
                $entradaCommit = $e->getMessage();
            }
        
            return $entradaCommit;
        }
    }