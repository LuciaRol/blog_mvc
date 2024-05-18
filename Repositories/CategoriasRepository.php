<?php
    namespace Repositories;
    use Lib\DataBase;
    use Models\Blog;
    use PDOException;
    use PDO;
    class categoriasRepository{
        private DataBase $conexion;
        private mixed $sql;
        function __construct(){
            $this->conexion = new DataBase();
        }
        public function findAll():? array {
            $this->conexion->querySQL("SELECT * FROM categorias;");
            
            return $this->extractAll();
        }
        public function countCategorias(): ?int {
            $this->conexion->querySQL("SELECT COUNT(*) as total FROM categorias;");
        
            $result = $this->conexion->register();
            
            return $result['total'];
        }
        public function extractAll():?array {
            $contactos = [];
            try{
                $contactosData = $this->conexion->allRegister();
                foreach ($contactosData as $contactoData){
                    $contactos[]=Blog::fromArray($contactoData);
                }
            }catch(PDOException){
                $contactos=null;
            }
            return $contactos;
        }
        public function addCategoria(array $data):?string {
            try{
                $this->sql = $this->conexion->prepareSQL("INSERT INTO categorias(nombre) VALUES (:nombre);");
                $this->sql->bindValue(":nombre",$data['nombre']);
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
                $this->sql = $this->conexion->prepareSQL("DELETE FROM categorias WHERE id = :id;");
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
        public function getData($id){
            $ruta = null;
            try {
                $this->sql = $this->conexion->prepareSQL("SELECT * FROM categorias WHERE id = :id");
                $this->sql->bindValue(":id", $id);
                $this->sql->execute();
                $rutaData = $this->sql->fetch(PDO::FETCH_ASSOC);
                $this->sql->closeCursor();
                $ruta = $rutaData ?: null;
                
            } catch (PDOException $e) {
                $ruta = $e->getMessage();
            }
        
            return $ruta;
        }
        public function edit($data) {
            $result = "";
            try{
                $this->sql = $this->conexion->prepareSQL("UPDATE categorias SET nombre=:nombre WHERE id = :id;");
                $this->sql->bindValue(":id",$data['editar']);
                $this->sql->bindValue(":nombre",$data['nombre']);
                $this->sql->execute();
                $result = null;
            }catch(PDOException $e){
                $result = $e->getMessage();
            }
            $this->sql->closeCursor();
            $this->sql = null;
            return $result;
        }
        public function search($opt,$search) :? array {
            $result =[];
            $resultados =[];
                $this->conexion->querySQL("SELECT * FROM categorias;");
                
                $result = $this->conexion->allRegister();
                $resultadosData = array_filter($result, function ($element) use ($opt,$search) {
                    $temporal = str_contains(strtolower($element[$opt]), strtolower($search));
                    return $temporal;
                });
                foreach ($resultadosData as $resultadoData){
                    $resultados[]=Blog::fromArray($resultadoData);
                }
            return $resultados;
        }
    }