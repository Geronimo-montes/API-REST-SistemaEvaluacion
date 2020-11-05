<?php 
    class ActividadProgramadaMapper extends Mapper{
        private function generarArray ($data){
            $array = [];
            foreach ($data as $actividad) {
                array_push($array, array(
                    "idActividadProgramada" => $actividad->getidActividadProgramada(),
                    "idPlanTrabajo" => $actividad->getidPlanTrabajo(),
                    "idNivelDesempeno" => $actividad->getidNivelDesempeno(),
                    "idPeriodoEvaluacion" => $actividad->getidPeriodoEvaluacion(),
                    "idCicloEscolar" => $actividad->getidCicloEscolar(),
                    "nivelDesempenoPonderado" => $actividad->getnivelDesempenoPonderado(),
                    "observacion" => $actividad->getobservacion(),
                    "fecha" => $actividad->getfecha(),
                    "estatus" => $actividad->getestatus()
                ));
            }
            return $array;
        }

        public function getActividadProgramada (){
            $sql = "SELECT * FROM actividadProgramada";
            
            $stmt = $this->db->query($sql);

            $results = [];
            while ($row = $stmt->fetch()){
                $results[] = new ActividadProgramadaEntity($row);
            }

            return $this->generarArray( $results );
        }

        public function getActividadProgramadaById ($id){
            $sql = "SELECT * FROM actividadProgramada WHERE idActividadProgramada = :idActividadProgramada";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":idActividadProgramada", $id, PDO::PARAM_INT);

            if($stmt->execute()){
                $results = [];
                while ($row = $stmt->fetch()){
                    $results[] = new ActividadProgramadaEntity($row);
                }
    
                return $this->generarArray( $results );
            }
        }

        public function getActividadProgramadaByPeriodo ($periodo){
            $sql = "SELECT * FROM actividadProgramada WHERE idPeriodoEvaluacion = :idPeriodoEvaluacion";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":idPeriodoEvaluacion", $periodo, PDO::PARAM_INT);

            if($stmt->execute()){
                $results = [];
                while ($row = $stmt->fetch()){
                    $results[] = new ActividadProgramadaEntity($row);
                }
    
                return $this->generarArray( $results );
            }
        }

        public function getActividadProgramadaByEstatus ($estatus){
            $sql = "SELECT * FROM actividadProgramada WHERE estatus = :estatus";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":estatus", $estatus, PDO::PARAM_STR, 1);

            if($stmt->execute()){
                $results = [];
                while ($row = $stmt->fetch()){
                    $results[] = new ActividadProgramadaEntity($row);
                }
    
                return $this->generarArray( $results );
            }
        }

        public function getActividadProgramadaByPeriodoEstatus ($periodo, $estatus){
            $sql = "SELECT * FROM actividadProgramada WHERE estatus = :estatus AND idPeriodoEvaluacion = :idPeriodoEvaluacion";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":estatus", $estatus, PDO::PARAM_STR, 1);
            $stmt->bindParam(":idPeriodoEvaluacion", $periodo, PDO::PARAM_INT);

            if($stmt->execute()){
                $results = [];
                while ($row = $stmt->fetch()){
                    $results[] = new ActividadProgramadaEntity($row);
                }
    
                return $this->generarArray( $results );
            }
        }

        public function updateActividadProgramada (ActividadProgramadaEntity $actividad){
            $sql = "UPDATE actividadProgramada SET
                idPlanTrabajo = :idPlanTrabajo,
                idNivelDesempeno = :idNivelDesempeno,
                idPeriodoEvaluacion = :idPeriodoEvaluacion,
                nivelDesempenoPonderado = :nivelDesempenoPonderado,
                observacion = :observacion,
                fecha = now(),
                estatus = :estatus
                WHERE idActividadProgramada = :idActividadProgramada;
            ";
            
            $stmt = $this->db->prepare($sql);

            $idActividadProgramada = $actividad->getidActividadProgramada();
            $idPlanTrabajo = $actividad->getidPlanTrabajo();
            $idNivelDesempeno = $actividad->getidNivelDesempeno();
            $idPeriodoEvaluacion = $actividad->getidPeriodoEvaluacion();
            $nivelDesempenoPonderado = $actividad->getnivelDesempenoPonderado();
            $observacion = $actividad->getobservacion();
            $fecha = $actividad->getfecha();
            $estatus = $actividad->getestatus();
            
            $stmt->bindParam(":idActividadProgramada", $idActividadProgramada, PDO::PARAM_INT);
            $stmt->bindParam(":idPlanTrabajo", $idPlanTrabajo, PDO::PARAM_INT);
            $stmt->bindParam(":idNivelDesempeno", $idNivelDesempeno, PDO::PARAM_INT);
            $stmt->bindParam(":idPeriodoEvaluacion", $idPeriodoEvaluacion, PDO::PARAM_INT);
            $stmt->bindParam(":nivelDesempenoPonderado", $nivelDesempenoPonderado, PDO::PARAM_INT);
            $stmt->bindParam(":observacion", $observacion, PDO::PARAM_STR, 300);
            //$stmt->bindParam(":fecha", $fecha, PDO::PARAM_STR, 10);
            $stmt->bindParam(":estatus", $estatus, PDO::PARAM_STR, 0);

            if($stmt->execute()){
                return $this->getActividadProgramadaById($actividad->getidActividadProgramada());
            }
        }

        public function insertActividadProgramada (ActividadProgramadaEntity $actividad){
            $sql = "INSERT INTO actividadProgramada (idPlanTrabajo, idNivelDesempeno, idPeriodoEvaluacion, idCicloEscolar, nivelDesempenoPonderado, observacion, fecha, estatus) VALUES (
                    :idPlanTrabajo,
                    :idNivelDesempeno,
                    :idPeriodoEvaluacion,
                    (SELECT idCicloEscolar from cicloescolar WHERE estatus = 'a'),
                    0,
                    :observacion,
                    now(),
                    'a'
                )
            ";

            $stmt = $this->db->prepare($sql);

            $idPlanTrabajo = $actividad->getidPlanTrabajo();
            $idNivelDesempeno = $actividad->getidNivelDesempeno();
            $idPeriodoEvaluacion = $actividad->getidPeriodoEvaluacion();
            $observacion = $actividad->getobservacion();

            $stmt->bindParam(":idPlanTrabajo", $idPlanTrabajo, PDO::PARAM_INT);
            $stmt->bindParam(":idNivelDesempeno", $idNivelDesempeno, PDO::PARAM_INT);
            $stmt->bindParam(":idPeriodoEvaluacion", $idPeriodoEvaluacion, PDO::PARAM_INT);
            $stmt->bindParam(":observacion", $observacion, PDO::PARAM_STR, 300);
            
            if($stmt->execute()){
                return "exito en la insercion";
            }
        }
    }
?>