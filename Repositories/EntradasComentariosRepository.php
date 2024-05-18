<?php
    namespace Repositories;
    use Lib\DataBase;
    use PDOException;
    use PDO;
    class entradasComentariosRepository{
        private DataBase $conexion;
        private mixed $sql;
        function __construct(){
            $this->conexion = new DataBase();
        }
        public function findAll() {
            $entradaCommit = null;
            try {
                $this->sql = $this->conexion->prepareSQL("SELECT   	
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
        public function buscarEntradas(string $query): ?array {
            $query = '%' . $query . '%';
            $entradaCommit = null;
            try {
                $this->sql = $this->conexion->prepareSQL("SELECT   	
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

        public function insertarEntrada($usuario_id, $categoria_id, $titulo, $descripcion, $fecha) {
            try {
                $this->sql = $this->conexion->prepareSQL("INSERT INTO entradas (usuario_id, categoria_id, titulo, descripcion, fecha) VALUES (:usuario_id, :categoria_id, :titulo, :descripcion, :fecha)");
                $this->sql->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
                $this->sql->bindValue(':categoria_id', $categoria_id, PDO::PARAM_INT);
                $this->sql->bindValue(':titulo', $titulo, PDO::PARAM_STR);
                $this->sql->bindValue(':descripcion', $descripcion, PDO::PARAM_STR);
                $this->sql->bindValue(':fecha', $fecha, PDO::PARAM_STR);
                $this->sql->execute();
                return true; // Éxito al insertar la entrada
            } catch (PDOException $e) {
                return false; // Error al insertar la entrada
            }
        }
        
    }