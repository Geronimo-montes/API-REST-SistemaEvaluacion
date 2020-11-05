<?php 
    class EvaluacionMapper extends Mapper{
        private function generarArray ($data){
            $array = [];
            foreach ($data as $evaluacion) {
                array_push($array, array(
                    "idAlumno" => $evaluacion->getidAlumno(),
                    "idAreaFormacion" => $evaluacion->getidAreaFormacion(),
                    "idPeriodoEvaluacion" => $evaluacion->getidPeriodoEvaluacion(),
                    "idNivelDesempeno" => $evaluacion->getidNivelDesempeno(),
                    "idCicloEscolar" => $evaluacion->getidCicloEscolar(),
                    "observacion" => $evaluacion->getobservacion(),
                    "estatus" => $evaluacion->getestatus()                  
                ));
            }
            return $array;
        }

        public function getEvaluaciones (){
            $sql = "SELECT * FROM evaluacion WHERE 'a' = (SELECT estatus FROM cicloEscolar WHERE estatus = 'a')";
            $stmt = $this->db->query($sql);
            $results = [];
            while ($row = $stmt->fetch()){ $results[] = new EvaluacionEntity($row); }
            return $this->generarArray( $results );
        }

        public function insertEvaluacion (EvaluacionEntity $evaluacion){
            $sql = "INSERT INTO evaluacion VALUES (
                :idAlumno,
                :idAreaFormacion,
                :idPeriodoEvaluacion,
                :idNivelDesempeno,
                :idCicloEscolar,
                :observacion,
                :estatus                
            )";

            $stmt = $this->db->prepare($sql);

            $idAlumno = $evaluacion->getidAlumno();
            $idAreaFormacion = $evaluacion->getidAreaFormacion();
            $idPeriodoEvaluacion = $evaluacion->getidPeriodoEvaluacion();
            $idNivelDesempeno = $evaluacion->getidNivelDesempeno();
            $idCicloEscolar = $evaluacion->getidCicloEscolar();
            $observacion = $evaluacion->getobservacion();
            $estatus = 'a';
            
            $stmt->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);
            $stmt->bindParam(":idAreaFormacion", $idAreaFormacion, PDO::PARAM_INT);
            $stmt->bindParam(":idPeriodoEvaluacion", $idPeriodoEvaluacion, PDO::PARAM_INT);
            $stmt->bindParam(":idNivelDesempeno", $idNivelDesempeno, PDO::PARAM_INT);
            $stmt->bindParam(":idCicloEscolar", $idCicloEscolar, PDO::PARAM_INT);
            $stmt->bindParam(":observacion", $observacion, PDO::PARAM_STR, 500);
            $stmt->bindParam(":estatus", $estatus, PDO::PARAM_STR, 1);            
            
            if($stmt->execute()){
                return "exito en la insercion";
            }
        }

        public function updateEvaluacion (EvaluacionEntity $evaluacion){
            $sql = "UPDATE evaluacion SET
                idAreaFormacion = :idAreaFormacion,
                idPeriodoEvaluacion = :idPeriodoEvaluacion,
                idNivelDesempeno = :idNivelDesempeno,
                idCicloEscolar = :idCicloEscolar,
                observacion = :observacion,
                estatus = :estatus
            WHERE idAlumno = :idAlumno";

            $stmt = $this->db->prepare($sql);

            $idAlumno = $evaluacion->getidAlumno();
            $idAreaFormacion = $evaluacion->getidAreaFormacion();
            $idPeriodoEvaluacion = $evaluacion->getidPeriodoEvaluacion();
            $idNivelDesempeno = $evaluacion->getidNivelDesempeno();
            $idCicloEscolar = $evaluacion->getidCicloEscolar();
            $observacion = $evaluacion->getobservacion();
            $estatus = $evaluacion->getestatus();
            
            $stmt->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);
            $stmt->bindParam(":idAreaFormacion", $idAreaFormacion, PDO::PARAM_INT);
            $stmt->bindParam(":idPeriodoEvaluacion", $idPeriodoEvaluacion, PDO::PARAM_INT);
            $stmt->bindParam(":idNivelDesempeno", $idNivelDesempeno, PDO::PARAM_INT);
            $stmt->bindParam(":idCicloEscolar", $idCicloEscolar, PDO::PARAM_INT);
            $stmt->bindParam(":observacion", $observacion, PDO::PARAM_STR, 500);
            $stmt->bindParam(":estatus", $estatus, PDO::PARAM_STR, 1);            
            
            if($stmt->execute()){
                return $this->getEvaluaciones();
            }
        }
    }
?>