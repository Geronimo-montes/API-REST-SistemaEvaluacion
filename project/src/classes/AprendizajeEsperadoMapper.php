<?php 
    class AprendizajeEsperadoMapper extends Mapper{
        public function getAprendizajeEsperado (){
            $sql = "SELECT *
            FROM aprendizajeEsperado WHERE estatus = 'a'";

            $stmt = $this->db->query($sql);

            $results = [];
            while ($row = $stmt->fetch()){
                $results[] = new AprendizajeEsperadoEntity($row);
            }

            return $results;
        }

        public function getAprendizajeEsperadoById ($id){
            $sql = "SELECT *
            FROM aprendizajeEsperado WHERE idAprendizajeEsperado = :idAprendizajeEsperado";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":idAprendizajeEsperado", $id, PDO::PARAM_INT);

            if($stmt->execute()){
                $results = [];
                $results = $stmt->fetch();
                
                if(!empty($results))
                    return new AprendizajeEsperadoEntity($results);
            }
        }
    }
?>