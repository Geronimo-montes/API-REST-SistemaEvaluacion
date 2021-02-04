<?php
class ActividadMapper extends Mapper
{
  private function generarArray($data)
  {
    $array = [];
    foreach ($data as $actividad) {
      array_push($array, array(
        "idPlanTrabajo" => $actividad->getidPlanTrabajo(),
        "idDocente" => $actividad->getidDocente(),
        "nombre"    => $actividad->getnombre(),
        "duracionMinutos"   => $actividad->getduracionMinutos(),
        "tipoActividad" => $actividad->gettipoActividad(),
        "idAprendizajeEsperado" => $actividad->getidAprendizajeEsperado(),
        "idDiagnostico" => $actividad->getidDiagnostico(),
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

  public function InsertActividad($actividad)
  {
    try {
      //datos principales de la actividad
      $sql = "INSERT INTO plantrabajo 
            (idDocente, nombre, duracionMinutos, tipoActividad, inicio, desarrollo, cierre, recursos, evaluacion, fechaModificacion, estatus) 
            VALUES
            (:idDocente, :nombre, :duracionMinutos, :tipoActividad, :inicio, :desarrollo, :cierre, :recursos, '', now(), 'a' )";

      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(":idDocente", $actividad['idDocente'], PDO::PARAM_INT);
      $stmt->bindParam(":nombre", $actividad['nombre'], PDO::PARAM_STR, 50);
      $stmt->bindParam(":duracionMinutos", $actividad['duracionMinutos'], PDO::PARAM_INT);
      $stmt->bindParam(":tipoActividad", $actividad['tipoActividad'], PDO::PARAM_STR, 1);
      $stmt->bindParam(":inicio", $actividad['inicio'], PDO::PARAM_STR, 2000);
      $stmt->bindParam(":desarrollo", $actividad['desarrollo'], PDO::PARAM_STR, 2000);
      $stmt->bindParam(":cierre", $actividad['cierre'], PDO::PARAM_STR, 2000);
      $stmt->bindParam(":recursos", $actividad['recursos'], PDO::PARAM_STR, 2000);

      $this->db->beginTransaction();

      $stmt->execute();
      $sql = 'SELECT LAST_INSERT_ID() as id';
      $stmt = $this->db->query($sql);
      $idPlanTrabajo = $stmt->fetch();
      //evidencias de la actividad
      $sql = "INSERT INTO evidencias 
              (idEvidencia, idPlanTrabajo, nombreEvidencia, descripcion, idFormato)
              VALUES 
              (:idEvidencia, :idPlanTrabajo, :nombreEvidencia, :descripcion, :idFormato)";
      $stmt = $this->db->prepare($sql);
      $idEvidencia = 1;

      foreach ($actividad['evidencia'] as $evidencia) {
        $stmt->bindParam(":idEvidencia", $idEvidencia, PDO::PARAM_INT);
        $stmt->bindParam(":idPlanTrabajo", $idPlanTrabajo['id'], PDO::PARAM_INT);
        $stmt->bindParam(":nombreEvidencia", $evidencia['nombreEvidencia'], PDO::PARAM_STR, 100);
        $stmt->bindParam(":descripcion", $evidencia['descripcion'], PDO::PARAM_STR, 200);
        $stmt->bindParam(":idFormato", $evidencia['idFormato'], PDO::PARAM_INT);
        $stmt->execute();
        $idEvidencia++;
      }
      //aprendizajes esperados de la actividad
      $sql = "INSERT INTO plantrabajo_aprendizajeesperado 
          (idAprendizajeEsperado, idPlanTrabajo)
          VALUES
          (:idAprendizajeEsperado, :idPlanTrabajo)";
      $stmt = $this->db->prepare($sql);

      foreach ($actividad['idAprendizajeEsperado'] as $valor) {
        $stmt->bindParam(":idPlanTrabajo", $idPlanTrabajo['id'], PDO::PARAM_INT);
        $stmt->bindParam(":idAprendizajeEsperado", $valor['idAprendizajeEsperado'], PDO::PARAM_INT);
        $stmt->execute();
      }

      $this->db->commit();
      return 'Insercción exitosa';
    } catch (PDOException $e) {
      if (stripos($e->getMessage(), 'DATABASE IS LOCKED') !== false) {
        $this->db->commit();
        usleep(250000);
      } else {
        $this->db->rollBack();
        throw new Exception("Error al insertar actividad", 1);
      }
    }
  }

  public function getActividades()
  {
    $sql = "SELECT * FROM plantrabajo WHERE estatus = 'a'";
    $stmt = $this->db->query($sql);
    $results = [];
    while ($row = $stmt->fetch()) {
      $results[] = new ActividadEntity($row);
    }
    return $this->generarArray($results);
  }

  public function getActividadById($id)
  {
    $actividadRes = [];
    $aprendizaje = [];
    $evidenciaRes = [];

    $sql = "SELECT ae.idAprendizajeEsperado , ae.idAreaFormacion , ae.descripcion , ae.estatus 
            FROM aprendizajeesperado AS ae
            JOIN plantrabajo_aprendizajeEsperado AS pta ON pta.idAprendizajeEsperado  = ae.idAprendizajeEsperado
            JOIN plantrabajo AS pt ON pt.idPlanTrabajo = pta.idPlanTrabajo
            WHERE pta.idPlanTrabajo = :idPlanTrabajo";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(":idPlanTrabajo", $id, PDO::PARAM_INT);
    if ($stmt->execute()) {
      $results = [];
      while ($row = $stmt->fetch()) {
        $results[] = new AprendizajeEsperadoEntity($row);
      }

      $aprendizaje = [];
      foreach ($results as $row) {
        $_sql = "SELECT *
        FROM areaformacion 
        WHERE estatus = 'a' 
        AND idAreaFormacion = :idAreaFormacion";

        $_stmt = $this->db->prepare($_sql);
        $idArea = $row->getidAprendizajeEsperado();
        $_stmt->bindParam(":idAreaFormacion", $idArea, PDO::PARAM_INT);

        if ($_stmt->execute()) {
          $area = [];
          while ($_row = $_stmt->fetch()) {
            $__row = new AreaFormacionEntity($_row);

            array_push($area, array(
              "idAreaFormacion" => $__row->getidAreaFormacion(),
              "descripcion" => $__row->getdescripcion(),
              "estatus" => $__row->getestatus(),
            ));
          }
        }

        array_push($aprendizaje, array(
          "idAprendizajeEsperado" => $row->getidAprendizajeEsperado(),
          "idAreaFormacion" => $area,
          "descripcion" => $row->getdescripcion(),
          "estatus" => $row->getestatus(),
        ));
      }
    }

    $sql = "SELECT * FROM evidencias WHERE idPlanTrabajo = :idPlanTrabajo";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(":idPlanTrabajo", $id, PDO::PARAM_INT);
    if ($stmt->execute()) {
      $results = [];
      while ($row = $stmt->fetch()) {
        $results[] = new EvidenciaEntity($row);
      }

      foreach ($results as $evidencia) {
        array_push($evidenciaRes, array(
          "idEvidencia" => $evidencia->getidEvidencia(),
          "idPlanTrabajo" => $evidencia->getidPlanTrabajo(),
          "nombreEvidencia" => $evidencia->getnombreEvidencia(),
          "descripcion" => $evidencia->getdescripcion(),
          "idFormato" => $evidencia->getidFormato(),
        ));
      }
    }

    $sql = "SELECT * FROM plantrabajo WHERE idPlanTrabajo = :idPlanTrabajo";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(":idPlanTrabajo", $id, PDO::PARAM_INT);
    if ($stmt->execute()) {
      $results = [];
      while ($row = $stmt->fetch()) {
        $results[] = new ActividadEntity($row);
      }
    }

    foreach ($results as $actividad) {
      array_push($actividadRes, array(
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
        "estatus"   => $actividad->getestatus(),
        "idAprendizajeEsperado" => $aprendizaje,
        "evidencia" => $evidenciaRes,
      ));
    }

    return $actividadRes[0];
  }

  public function UpdateActividadById(ActividadEntity $actividad)
  {
    $sql = "UPDATE plantrabajo SET   
      idDocente               = :idDocente,
      nombre                  = :nombre,
      duracionMinutos         = :duracionMinutos,
      tipoActividad           = :tipoActividad,
      idAprendizajeEsperado   = :idAprendizajeEsperado,
      idDiagnostico           = :idDiagnostico,
      inicio                  = :inicio,
      desarrollo              = :desarrollo,
      cierre                  = :cierre,
      recursos                = :recursos,
      evaluacion              = :evaluacion,
      fechaModificacion       = now(),
      estatus                 = :estatus
    WHERE idPlanTrabajo = :idPlanTrabajo";

    $stmt = $this->db->prepare($sql);

    $idPlanTrabajo = $actividad->getidPlanTrabajo();
    $idDocente = $actividad->getidDocente();
    $nombre = $actividad->getnombre();
    $duracionMinutos = $actividad->getduracionMinutos();
    $tipoActividad = $actividad->gettipoActividad();
    $idAprendizajeEsperado         = $actividad->getidAprendizajeEsperado();
    $idDiagnostico         = $actividad->getidDiagnostico();
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
    $stmt->bindParam(":idAprendizajeEsperado", $idAprendizajeEsperado, PDO::PARAM_INT);
    $stmt->bindParam(":idDiagnostico", $idDiagnostico, PDO::PARAM_INT);
    $stmt->bindParam(":inicio", $inicio, PDO::PARAM_STR);
    $stmt->bindParam(":desarrollo", $desarrollo, PDO::PARAM_STR);
    $stmt->bindParam(":cierre", $cierre, PDO::PARAM_STR);
    $stmt->bindParam(":recursos", $recursos, PDO::PARAM_STR);
    $stmt->bindParam(":evaluacion", $evaluacion, PDO::PARAM_STR);
    $stmt->bindParam(":estatus", $estatus, PDO::PARAM_STR);
    $stmt->bindParam(":idPlanTrabajo", $idPlanTrabajo, PDO::PARAM_INT);

    if ($stmt->execute()) {
      return $this->getActividadById($actividad->getidPlanTrabajo());
    }
  }
}
