<?php 
    class PeriodoEvaluacionMapper extends Mapper{
        public function getPeriodosEvaluacion (){
            $sql = "SELECT idPeriodoEvaluacion, nombre, numeroEvaluacion, mesInicio, mesFinal, estatus 
            FROM periodoEvaluacion WHERE estatus = 'a'";

            $stmt = $this->db->query($sql);

            $results = [];
            while ($row = $stmt->fetch()){
                $results[] = new PeriodoEvaluacionEntity($row);
            }

            return $results;
        }

        public function getPeriodoEvaluacionById ($id){
            $sql = "SELECT idPeriodoEvaluacion, nombre, numeroEvaluacion, mesInicio, mesFinal, estatus 
            FROM periodoEvaluacion WHERE idPeriodoEvaluacion = :idPeriodoEvaluacion";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":idPeriodoEvaluacion", $id, PDO::PARAM_INT);

            if($stmt->execute()){
                $results = [];
                $results = $stmt->fetch();
                
                if(!empty($results))
                    return new PeriodoEvaluacionEntity($results);
            }
        }
    }
?>