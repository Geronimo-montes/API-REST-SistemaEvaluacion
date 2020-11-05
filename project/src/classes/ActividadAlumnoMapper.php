<?php 
    class ActividadAlumnoMapper extends Mapper{
        private function generarArray ($data){
            $array = [];
            foreach ($data as $actividad) {
                array_push($array, array(
                    "idActividadProgramada" => $actividad->getidActividadProgramada(),
                    "idAlumno" => $actividad->getidAlumno(),
                    "idNivelDesempeno" => $actividad->getidNivelDesempeno(),
                    "observacion" => $actividad->getobservacion(),
                    "rutaEvidencia" => $actividad->getrutaEvidencia()
                ));
            }
            return $array;
        }
        
        public function getActividadAlumno (){
            $sql = "SELECT * FROM actividadAlumno";
            $stmt = $this->db->query($sql);
            $results = [];
            
            while ($row = $stmt->fetch()){
                $results[] = new ActividadAlumnoEntity($row);
            }

            return $this->generarArray( $results );
        }

        public function getActividadAlumnoById ($id){
            $sql = "SELECT * FROM actividadAlumno WHERE idActividadProgramada = :idActividadProgramada";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":idActividadProgramada", $id, PDO::PARAM_INT);

            if($stmt->execute()){
                $results = [];
                while ($row = $stmt->fetch()){
                    $results[] = new ActividadAlumnoEntity($row);
                }
                return $this->generarArray( $results );
            }
        }

        public function getActividadAlumnoByIdAlumno ($idAlumno, $id){
            $sql = "SELECT * FROM actividadAlumno 
                    WHERE idActividadProgramada = :idActividadProgramada
                    AND idAlumno = :idAlumno";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":idActividadProgramada", $id, PDO::PARAM_INT);
            $stmt->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);

            if($stmt->execute()){
                $results = [];
                while ($row = $stmt->fetch()){
                    $results[] = new ActividadAlumnoEntity($row);
                }
                return $this->generarArray( $results );
            }
        }

        public function updateActividadAlumno (ActividadAlumnoEntity $actividad){
            $sql = "UPDATE actividadAlumno SET
                idNivelDesempeno = :idNivelDesempeno,
                observacion = :observacion
                WHERE idActividadProgramada = :idActividadProgramada AND idAlumno = :idAlumno
            ";
            
            $stmt = $this->db->prepare($sql);
            $idNivelDesempeno = $actividad->getidNivelDesempeno();
            $observacion = $actividad->getobservacion();
            $idActividadProgramada = $actividad->getidActividadProgramada();
            $idAlumno = $actividad->getidAlumno();

            $stmt->bindParam(":idNivelDesempeno", $idNivelDesempeno, PDO::PARAM_INT);
            $stmt->bindParam(":observacion", $observacion, PDO::PARAM_STR, 300);
            $stmt->bindParam(":idActividadProgramada", $idActividadProgramada, PDO::PARAM_INT);
            $stmt->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);

            if($stmt->execute()){
                return $this->getActividadAlumnoByIdAlumno($actividad->getidAlumno(), $actividad->getidActividadProgramada());
            }
        }

        public function insertActividadProgramada (ActividadAlumnoEntity $actividad){
            $sql = "INSERT INTO actividadAlumno VALUES (
                :idActividadProgramada,
                :idAlumno,
                NULL,
                '',
                :rutaEvidencia
                )
            ";

            $stmt = $this->db->prepare($sql);

            $idActividadProgramada = $actividad->getidActividadProgramada();
            $idAlumno = $actividad->getidAlumno();
            $rutaEvidencia = $actividad->getrutaEvidencia();

            $stmt->bindParam(":idActividadProgramada", $idActividadProgramada, PDO::PARAM_INT);
            $stmt->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);
            $stmt->bindParam(":rutaEvidencia", $rutaEvidencia, PDO::PARAM_STR, 300);
            
            if($stmt->execute())
                return "exito en la insercion";
        }
    }
?>