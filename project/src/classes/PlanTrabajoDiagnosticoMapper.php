<?php 
    class PlanTrabajoDiagnosticoMapper extends Mapper{
        private function generarArray ($data){
            $array = [];
            foreach ($data as $value) {
                array_push($array, array(
                    "idDiagnostico" => $value->getidDiagnostico(), 
                    "idPlanTrabajo" => $value->getidPlanTrabajo()                 
                ));
            }
            return $array;
        }

        public function getplanTrabajoDiagnosticoById($id){
            $sql = "SELECT * FROM planTrabajo_diagnostico WHERE idPlanTrabajo = :idPlanTrabajo";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":idPlanTrabajo", $id, PDO::PARAM_INT);

            if($stmt->execute()){
                $results = [];
                while ($row = $stmt->fetch()){ $results[] = new CuadroHonorEntity($row); }
                return $this->generarArray( $results );
            }
        }

        public function insertplanTrabajoDiagnostico(PlanTrabajoDiagnosticoEntity $data){
            $sql = "INSERT INTO planTrabajo_diagnostico VALUES (:idDiagnostico, :idPlanTrabajo)";

            $idDiagnostico = $data->getidDiagnostico();
            $idPlanTrabajo = $data->getidPlanTrabajo();
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":idDiagnostico", $idDiagnostico, PDO::PARAM_INT);
            $stmt->bindParam(":idPlanTrabajo", $idPlanTrabajo, PDO::PARAM_INT);

            if($stmt->execute()){
                return "exito en la insercion";
            }
        }
    }
?>