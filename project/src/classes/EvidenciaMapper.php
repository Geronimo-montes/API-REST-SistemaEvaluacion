<?php 
    class EvidenciaMapper extends Mapper{
        private function generarArray ($data){
            $array = [];
            foreach ($data as $evidencia) {
                array_push($array, array(
                    "idEvidencia" => $evidencia->getidEvidencia(),
                    "idPlanTrabajo" => $evidencia->getidPlanTrabajo(),
                    "nombreEvidencia" => $evidencia->getnombreEvidencia(),
                    "descripcion" => $evidencia->getdescripcion(),
                    "formatoEsperado" => $evidencia->getformatoEsperado(),
                    "evidenciaOpcional" => $evidencia->getevidenciaOpcional()
                ));
            }
            return $array;
        }

        public function getEvidenciaByIdPlanTrabajo($id){
            $sql = "SELECT * FROM evidencias WHERE idPlanTrabajo = :idPlanTrabajo";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":idPlanTrabajo", $id, PDO::PARAM_INT);

            if($stmt->execute()){
                $results = [];
                while ($row = $stmt->fetch()){ $results[] = new EvidenciaEntity($row); }
                return $this->generarArray( $results );
            }
        }

        public function updateEvidencia(EvidenciaEntity $evidencia){
            $sql = "UPDATE evidencias SET
                nombreEvidencia = :nombreEvidencia,
                descripcion = :descripcion,
                formatoEsperado = :formatoEsperado,
                evidenciaOpcional = :evidenciaOpcional
            WHERE idPlanTrabajo = :idPlanTrabajo AND idEvidencia = :idEvidencia";

            $nombreEvidencia = $evidencia->getnombreEvidencia();
            $descripcion = $evidencia->getdescripcion();
            $formatoEsperado = $evidencia->getformatoEsperado();
            $evidenciaOpcional = $evidencia->getevidenciaOpcional();
            $idPlanTrabajo = $evidencia->getidPlanTrabajo();
            $idEvidencia = $evidencia->getidEvidencia();
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":nombreEvidencia", $nombreEvidencia, PDO::PARAM_STR, 100);
            $stmt->bindParam(":descripcion", $descripcion, PDO::PARAM_STR, 200);
            $stmt->bindParam(":formatoEsperado", $formatoEsperado, PDO::PARAM_STR, 8);
            $stmt->bindParam(":evidenciaOpcional", $evidenciaOpcional, PDO::PARAM_STR, 1);
            $stmt->bindParam(":idPlanTrabajo", $idPlanTrabajo, PDO::PARAM_INT);
            $stmt->bindParam(":idEvidencia", $idEvidencia, PDO::PARAM_INT);

            if($stmt->execute()){
                return $this->getEvidenciaByIdPlanTrabajo($idPlanTrabajo);
            }
        }

        public function insertEvidencia(EvidenciaEntity $evidencia){
            $sql = "INSERT INTO evidencias (idEvidencia, idPlanTrabajo, nombreEvidencia, descripcion, formatoEsperado, evidenciaOpcional) VALUES 
            (1, :idPlanTrabajo, :nombreEvidencia, :descripcion, :formatoEsperado, :evidenciaOpcional)";

            $idPlanTrabajo = $evidencia->getidPlanTrabajo();
            $nombreEvidencia = $evidencia->getnombreEvidencia();
            $descripcion = $evidencia->getdescripcion();
            $formatoEsperado = $evidencia->getformatoEsperado();
            $evidenciaOpcional = $evidencia->getevidenciaOpcional();

            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":nombreEvidencia", $nombreEvidencia, PDO::PARAM_STR, 100);
            $stmt->bindParam(":descripcion", $descripcion, PDO::PARAM_STR, 200);
            $stmt->bindParam(":formatoEsperado", $formatoEsperado, PDO::PARAM_STR, 8);
            $stmt->bindParam(":evidenciaOpcional", $evidenciaOpcional, PDO::PARAM_STR, 1);
            $stmt->bindParam(":idPlanTrabajo", $idPlanTrabajo, PDO::PARAM_INT);

            if($stmt->execute()){
                return "exito en la insercion";
            }
        }
    }
?>