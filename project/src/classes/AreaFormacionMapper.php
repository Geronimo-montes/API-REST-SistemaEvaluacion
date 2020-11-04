<?php 
    class AreaFormacionMapper extends Mapper{
        public function getAreaFormacion (){
            $sql = "SELECT *
            FROM areaFormacion WHERE estatus = 'a'";

            $stmt = $this->db->query($sql);

            $results = [];
            while ($row = $stmt->fetch()){
                $results[] = new AreaFormacionEntity($row);
            }

            return $results;
        }

        public function getAreaFormacionById ($id){
            $sql = "SELECT *
            FROM areaFormacion WHERE idAreaFormacion = :idAreaFormacion";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":idAreaFormacion", $id, PDO::PARAM_INT);

            if($stmt->execute()){
                $results = [];
                $results = $stmt->fetch();
                
                if(!empty($results))
                    return new AreaFormacionEntity($results);
            }
        }
    }
?>