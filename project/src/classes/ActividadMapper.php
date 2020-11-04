<?php 
    class ActividadMapper extends Mapper{
        
        public function InsertActividad (ActividadEntity $actividad)
        /**************************************************************************
        * Parametros:	entidad actividad
        * Proposito:	insertar una nueva actividad
        * Return:		true flase
        **************************************************************************/{
            $sql = "INSERT INTO planTrabajo (idAprendizajeEsperado, idAreaFormacion, idDocente, idDiagnostico, nombre, duracionMinutos, tipoActividad, inicio, desarrollo, cierre, recursos, evaluacion, fechaModificacion, estatus) 
            VALUES
            (
                :idAprendizajeEsperado,
                :idAreaFormacion,
                :idDocente,
                :idDiagnostico,                
                :nombre,
                :duracionMinutos,
                :tipoActividad,
                :inicio,
                :desarrollo,
                :cierre,
                :recursos,
                :evaluacion,
                now(),
                'a'
            )";

            $stmt = $this->db->prepare($sql);

            $idAprendizajeEsperado = $actividad->getidAprendizajeEsperado();
            $idAreaFormacion       = $actividad->getidAreaFormacion();
            $idDocente             = $actividad->getidDocente();
            $idDiagnostico         = $actividad->getidDiagnostico();
            $nombre                = $actividad->getnombre();
            $duracionMinutos       = $actividad->getduracionMinutos();
            $tipoActividad         = $actividad->gettipoActividad();
            $inicio                = $actividad->getinicio();
            $desarrollo            = $actividad->getdesarrollo();
            $cierre                = $actividad->getcierre();
            $recursos              = $actividad->getrecursos();
            $evaluacion            = $actividad->getevaluacion();
            //$fechaModificacion = $actividad->getfechaModificacion();

            $stmt->bindParam(":idAprendizajeEsperado", $idAprendizajeEsperado, PDO::PARAM_INT);
            $stmt->bindParam(":idAreaFormacion", $idAreaFormacion, PDO::PARAM_INT);
            $stmt->bindParam(":idDocente", $idDocente, PDO::PARAM_INT);
            $stmt->bindParam(":idDiagnostico", $idDiagnostico, PDO::PARAM_INT);
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR, 50);
            $stmt->bindParam(":duracionMinutos", $duracionMinutos, PDO::PARAM_INT);
            $stmt->bindParam(":tipoActividad", $tipoActividad, PDO::PARAM_STR, 1);
            $stmt->bindParam(":inicio", $inicio, PDO::PARAM_STR, 2000);
            $stmt->bindParam(":desarrollo", $desarrollo, PDO::PARAM_STR, 2000);
            $stmt->bindParam(":cierre", $cierre, PDO::PARAM_STR, 2000);
            $stmt->bindParam(":recursos", $recursos, PDO::PARAM_STR, 2000);
            $stmt->bindParam(":evaluacion", $evaluacion, PDO::PARAM_STR, 2000);
            //$stmt->bindParam(":fechaModificacion", $fechaModificacion, PDO::PARAM_STR);

            if($stmt->execute()){
                return "exito en la insercion";
            }
        }

        public function getActividades ()
        /**************************************************************************
        * Parametros:	
        * Proposito:	listar activiades 
        * Return:		array
        **************************************************************************/{
            $sql = "SELECT   
                    idPlanTrabajo,
                    idAprendizajeEsperado,
                    idAreaFormacion,
                    idDocente,
                    idDiagnostico,
                    nombre,
                    duracionMinutos,
                    tipoActividad,
                    inicio,
                    desarrollo,
                    cierre,
                    recursos,
                    evaluacion,
                    fechaModificacion,
                    estatus
                FROM planTrabajo pt
                WHERE estatus = 'a'"
            ;

            $stmt = $this->db->query($sql);

            $results = [];
            while ($row = $stmt->fetch()){
                $results[] = new ActividadEntity($row);
            }

            return $results;
        }

        public function getActividadById ($id)
        /**************************************************************************
        * Parametros:	
        * Proposito:	listar activiades 
        * Return:		array
        **************************************************************************/{
            $sql = "SELECT   
                    idPlanTrabajo,
                    idAprendizajeEsperado,
                    idAreaFormacion,
                    idDocente,
                    idDiagnostico,
                    nombre,
                    duracionMinutos,
                    tipoActividad,
                    inicio,
                    desarrollo,
                    cierre,
                    recursos,
                    evaluacion,
                    fechaModificacion,
                    estatus
                FROM planTrabajo
                WHERE idPlanTrabajo = :idPlanTrabajo"
            ;

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":idPlanTrabajo", $id, PDO::PARAM_INT);

            if($stmt->execute()){
                $results = [];
                $results = $stmt->fetch();
                
                if(!empty($results))
                    return new ActividadEntity($results);
            }
        }

        public function UpdateActividadById (ActividadEntity $actividad)
        /**************************************************************************
        * Parametros:	Objeto del tupo ActividadEntity
        * Proposito:	Actualizar sus datos
        * Return:		array
        **************************************************************************/{
            $sql = "UPDATE planTrabajo SET   
                    idAprendizajeEsperado   = :idAprendizajeEsperado,
                    idAreaFormacion         = :idAreaFormacion,
                    idDocente               = :idDocente,
                    idDiagnostico           = :idDiagnostico,
                    nombre                  = :nombre,
                    duracionMinutos         = :duracionMinutos,
                    tipoActividad           = :tipoActividad,
                    inicio                  = :inicio,
                    desarrollo              = :desarrollo,
                    cierre                  = :cierre,
                    recursos                = :recursos,
                    evaluacion              = :evaluacion,
                    fechaModificacion       = now(),
                    estatus                 = :estatus
                WHERE idPlanTrabajo = :idPlanTrabajo"
            ;

            $stmt = $this->db->prepare($sql);

            $idPlanTrabajo = $actividad->getidPlanTrabajo();
            $idAprendizajeEsperado = $actividad->getidAprendizajeEsperado();
            $idAreaFormacion = $actividad->getidAreaFormacion();
            $idDocente = $actividad->getidDocente();
            $idDiagnostico = $actividad->getidDiagnostico();
            $nombre = $actividad->getnombre();
            $duracionMinutos = $actividad->getduracionMinutos();
            $tipoActividad = $actividad->gettipoActividad();
            $inicio = $actividad->getinicio();
            $desarrollo = $actividad->getdesarrollo();
            $cierre = $actividad->getcierre();
            $recursos = $actividad->getrecursos();
            $evaluacion = $actividad->getevaluacion();
            $estatus = $actividad->getestatus();

            $stmt->bindParam(":idAprendizajeEsperado", $idAprendizajeEsperado, PDO::PARAM_INT);
            $stmt->bindParam(":idAreaFormacion", $idAreaFormacion, PDO::PARAM_INT);
            $stmt->bindParam(":idDocente", $idDocente, PDO::PARAM_INT);
            $stmt->bindParam(":idDiagnostico", $idDiagnostico, PDO::PARAM_INT);
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":duracionMinutos", $duracionMinutos, PDO::PARAM_STR);
            $stmt->bindParam(":tipoActividad", $tipoActividad, PDO::PARAM_STR);
            $stmt->bindParam(":inicio", $inicio, PDO::PARAM_STR);
            $stmt->bindParam(":desarrollo", $desarrollo, PDO::PARAM_STR);
            $stmt->bindParam(":cierre", $cierre, PDO::PARAM_STR);
            $stmt->bindParam(":recursos", $recursos, PDO::PARAM_STR);
            $stmt->bindParam(":evaluacion", $evaluacion, PDO::PARAM_STR);
            $stmt->bindParam(":estatus", $estatus, PDO::PARAM_STR);
            $stmt->bindParam(":idPlanTrabajo", $idPlanTrabajo, PDO::PARAM_INT);

            if($stmt->execute()){
                return $this->getActividadById($actividad->getidPlanTrabajo());
            }
        }
    }
?>