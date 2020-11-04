<?php 
    class NivelDesempenoMapper extends Mapper{
        public function getNivelDesempeno (){
            $sql = "SELECT idNivelDesempeno, nombre, abreviacion, valorNumerico 
            FROM NivelDesempeno";

            $stmt = $this->db->query($sql);

            $results = [];
            while ($row = $stmt->fetch()){
                $results[] = new NivelDesempenoEntity($row);
            }

            return $results;
        }

        public function getNivelDesempenoById ($id){
            $sql = "SELECT idNivelDesempeno, nombre, abreviacion, valorNumerico 
            FROM NivelDesempeno WHERE idNivelDesempeno = :idNivelDesempeno";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":idNivelDesempeno", $id, PDO::PARAM_INT);

            if($stmt->execute()){
                $results = [];
                $results = $stmt->fetch();
                
                if(!empty($results))
                    return new NivelDesempenoEntity($results);
            }
        }
    }
?>