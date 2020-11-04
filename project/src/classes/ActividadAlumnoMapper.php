<?php 
    class ActividadAlumnoMapper extends Mapper{
        public function getActividadAlumno ()
        /**************************************************************************
        * Parametros:	
        * Proposito:	Listar todas las actividades con estatus activa
        * Return:		array
        **************************************************************************/{
            $sql = "SELECT * FROM actividadAlumno";
            
            $stmt = $this->db->query($sql);

            $results = [];
            while ($row = $stmt->fetch()){
                $results[] = new ActividadAlumnoEntity($row);
            }

            return $results;
        }

        public function getActividadAlumnoById ($id)
        /**************************************************************************
        * Parametros:	
        * Proposito:	Listar todas las actividades con el id especificado
        * Return:		array
        **************************************************************************/{
            $sql = "SELECT * FROM actividadAlumno WHERE idActividadProgramada = :idActividadProgramada";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":idActividadProgramada", $id, PDO::PARAM_INT);

            if($stmt->execute()){
                $results = [];
                $results = $stmt->fetch();
                
                if(!empty($results))
                    return new ActividadProgramadaEntity($results);
            }
        }

        public function getActividadAlumnoByIdAlumno ($id, $idAlumno)
        /**************************************************************************
        * Parametros:	
        * Proposito:	Listar todas las actividades con el id especificado
        * Return:		array
        **************************************************************************/{
            $sql = "SELECT * FROM actividadAlumno 
                    WHERE idActividadProgramada = :idActividadProgramada
                    AND idAlumno = :idAlumno
            ";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":idActividadProgramada", $id, PDO::PARAM_INT);
            $stmt->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);

            if($stmt->execute()){
                $results = [];
                $results = $stmt->fetch();
                
                if(!empty($results))
                    return new ActividadProgramadaEntity($results);
            }
        }

        public function updateActividadAlumno (ActividadAlumnoEntity $actividad)
        /**************************************************************************
        * Parametros:	
        * Proposito:	actualizar los campos en la Bd
        * Return:		array
        **************************************************************************/{
            $sql = "UPDATE actividadAlumno SET
                idNivelDesempeno = :idNivelDesempeno,
                observacion = :observacion,
                WHERE idActividadProgramada = :idActividadProgramada AND idAlumno = :idAlumno;
            ";
            
            $stmt = $this->db->prepare($sql);
            $idNivelDesempeno = $actividad->getidNivelDesempeno();
            $observacion = $actividad->getobservacion();
            
            $stmt->bindParam(":idNivelDesempeno", $idNivelDesempeno, PDO::PARAM_INT);
            $stmt->bindParam(":observacion", $observacion, PDO::PARAM_STR, 300);

            if($stmt->execute()){
                return $this->getActividadAlumnoByIdAlumno($actividad->getidActividadProgramada(), $actividad->getidAlumno());
            }
        }

        public function insertActividadProgramada (ActividadAlumnoEntity $actividad)
        /**************************************************************************
        * Parametros:	objeto tipo actividadprogramadaentity que contiene las caracteristicas a intestar
        * Proposito:	insertar un nueva actividad programada
        * Return:		true false
        **************************************************************************/{
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
            
            if($stmt->execute()){
                return "exito en la insercion";
            }
        }
    }
?>