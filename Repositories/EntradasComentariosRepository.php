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
                                                                entradas.id as entrada_id,
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

        public function findEntradasUser($usuario_id) {
            $entradaCommit = null;
            try {
                $this->sql = $this->conexion->prepareSQL("SELECT   	
                                                                entradas.id as entrada_id,
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
                                                            WHERE usuarios.id = :usuario_id");

                $this->sql->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
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

        public function editarEntrada($usuario_id, $categoria_id, $titulo, $descripcion, $fecha, $entrada_id) {
            try {
                $this->sql = $this->conexion->prepareSQL("UPDATE entradas SET usuario_id = :usuario_id, categoria_id = :categoria_id, titulo = :titulo, descripcion = :descripcion, fecha = :fecha WHERE id = :entrada_id");
                $this->sql->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
                $this->sql->bindValue(':categoria_id', $categoria_id, PDO::PARAM_INT);
                $this->sql->bindValue(':titulo', $titulo, PDO::PARAM_STR);
                $this->sql->bindValue(':descripcion', $descripcion, PDO::PARAM_STR);
                $this->sql->bindValue(':fecha', $fecha, PDO::PARAM_STR);
                $this->sql->bindValue(':entrada_id', $entrada_id, PDO::PARAM_INT);
                $this->sql->execute();
                return true; // Éxito al editar la entrada
            } catch (PDOException $e) {
                return false; // Error al editar la entrada
            }
        }

        public function eliminarEntrada($entrada_id): bool {
            try {
                $this->sql = $this->conexion->prepareSQL("DELETE FROM entradas WHERE id = :entrada_id");
                $this->sql->bindValue(':entrada_id', $entrada_id, PDO::PARAM_INT);
                $this->sql->execute();
                return true; // Éxito al eliminar la entrada
            } catch (PDOException $e) {
                return false; // Error al eliminar la entrada
            }
        }

        public function obtenerEntradasCategoria(string $categoria): ?array {
            $entradaCommit = null;
            try {
                $this->sql = $this->conexion->prepareSQL("SELECT   	
                                                                entradas.id as entrada_id,
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
                                                            INNER JOIN usuarios
                                                            ON usuarios.id = entradas.usuario_id
                                                            INNER JOIN categorias
                                                            ON categorias.id = entradas.categoria_id
                                                            WHERE categorias.nombre = :categoria");
                
                $this->sql->bindValue(':categoria', $categoria, PDO::PARAM_STR);
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