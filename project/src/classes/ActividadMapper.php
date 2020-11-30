<?php 
    class ActividadMapper extends Mapper{
        private function generarArray ($data){
            $array = [];
            foreach ($data as $actividad) {
                array_push($array, array(
                    "idPlanTrabajo" => $actividad->getidPlanTrabajo(),
                    "idDocente" => $actividad->getidDocente(),
                    "nombre"    => $actividad->getnombre(),
                    "duracionMinutos"   => $actividad->getduracionMinutos(),
                    "tipoActividad" => $actividad->gettipoActividad(),
                    "inicio"    => $actividad->getinicio(),
                    "desarrollo"    => $actividad->getdesarrollo(),
                    "cierre"    => $actividad->getcierre(),
                    "recursos"  => $actividad->getrecursos(),
                    "evaluacion"    => $actividad->getevaluacion(),
                    "fechaModificacion" => $actividad->getfechaModificacion(),
                    "estatus"   => $actividad->getestatus()
                ));
            }
            return $array;
        }
        
        public function InsertActividad (ActividadEntity $actividad){
            $sql = "INSERT INTO planTrabajo (idDocente, nombre, duracionMinutos, tipoActividad, inicio, desarrollo, cierre, recursos, evaluacion, fechaModificacion, estatus) 
            VALUES
            (
                :idDocente,
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

            $idDocente             = $actividad->getidDocente();
            $nombre                = $actividad->getnombre();
            $duracionMinutos       = $actividad->getduracionMinutos();
            $tipoActividad         = $actividad->gettipoActividad();
            $inicio                = $actividad->getinicio();
            $desarrollo            = $actividad->getdesarrollo();
            $cierre                = $actividad->getcierre();
            $recursos              = $actividad->getrecursos();
            $evaluacion            = $actividad->getevaluacion();
            //$fechaModificacion = $actividad->getfechaModificacion();

            $stmt->bindParam(":idDocente", $idDocente, PDO::PARAM_INT);
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

        public function getActividades (){
            $sql = "SELECT * FROM planTrabajo pt WHERE estatus = 'a'";
            $stmt = $this->db->query($sql);
            $results = [];
            while ($row = $stmt->fetch()){ $results[] = new ActividadEntity($row); }
            return $this->generarArray( $results );
        }

        public function getActividadById ($id){
            $sql = "SELECT * FROM planTrabajo WHERE idPlanTrabajo = :idPlanTrabajo";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":idPlanTrabajo", $id, PDO::PARAM_INT);

            if($stmt->execute()){
                $results = [];
                while ($row = $stmt->fetch()){ $results[] = new ActividadEntity($row); }
                return $this->generarArray( $results );
            }
        }

        public function UpdateActividadById (ActividadEntity $actividad){
            $sql = "UPDATE planTrabajo SET   
                    idDocente               = :idDocente,
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
            $idDocente = $actividad->getidDocente();
            $nombre = $actividad->getnombre();
            $duracionMinutos = $actividad->getduracionMinutos();
            $tipoActividad = $actividad->gettipoActividad();
            $inicio = $actividad->getinicio();
            $desarrollo = $actividad->getdesarrollo();
            $cierre = $actividad->getcierre();
            $recursos = $actividad->getrecursos();
            $evaluacion = $actividad->getevaluacion();
            $estatus = $actividad->getestatus();

            $stmt->bindParam(":idDocente", $idDocente, PDO::PARAM_INT);
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