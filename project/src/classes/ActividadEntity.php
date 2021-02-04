<?php
class ActividadEntity
{
  protected $idPlanTrabajo;
  protected $idDocente;
  protected $nombre;
  protected $duracionMinutos;
  protected $tipoActividad;
  protected $idAprendizajeEsperado;
  protected $idDiagnostico;
  protected $inicio;
  protected $desarrollo;
  protected $cierre;
  protected $recursos;
  protected $evaluacion;
  protected $fechaModificacion;
  protected $estatus;

  public function __construct(array $data)
  {
    (isset($data['idPlanTrabajo']))         ? $this->idPlanTrabajo         = $data['idPlanTrabajo']         : $this->idPlanTrabajo = NULL;
    (isset($data['idDocente']))             ? $this->idDocente             = $data['idDocente']             : $this->idDocente = NULL;
    (isset($data['nombre']))                ? $this->nombre                = $data['nombre']                : $this->nombre = NULL;
    (isset($data['duracionMinutos']))       ? $this->duracionMinutos       = $data['duracionMinutos']       : $this->duracionMinutos = NULL;
    (isset($data['tipoActividad']))         ? $this->tipoActividad         = $data['tipoActividad']         : $this->tipoActividad = NULL;
    (isset($data['idAprendizajeEsperado']))         ? $this->idAprendizajeEsperado         = $data['idAprendizajeEsperado']         : $this->idAprendizajeEsperado = NULL;
    (isset($data['idDiagnostico']))         ? $this->idDiagnostico         = $data['idDiagnostico']         : $this->idDiagnostico = NULL;
    (isset($data['inicio']))                ? $this->inicio                = $data['inicio']                : $this->inicio = NULL;
    (isset($data['desarrollo']))            ? $this->desarrollo            = $data['desarrollo']            : $this->desarrollo = NULL;
    (isset($data['cierre']))                ? $this->cierre                = $data['cierre']                : $this->cierre = NULL;
    (isset($data['recursos']))              ? $this->recursos              = $data['recursos']              : $this->recursos = NULL;
    (isset($data['evaluacion']))            ? $this->evaluacion            = $data['evaluacion']            : $this->evaluacion = NULL;
    (isset($data['fechaModificacion']))     ? $this->fechaModificacion     = $data['fechaModificacion']     : $this->fechaModificacion = NULL;
    (isset($data['estatus']))               ? $this->estatus               = $data['estatus']               : $this->estatus = NULL;
  }

  public function getidPlanTrabajo()
  {
    return $this->idPlanTrabajo;
  }
  public function getidDocente()
  {
    return $this->idDocente;
  }
  public function getnombre()
  {
    return $this->nombre;
  }
  public function getduracionMinutos()
  {
    return $this->duracionMinutos;
  }
  public function gettipoActividad()
  {
    return $this->tipoActividad;
  }
  public function getidAprendizajeEsperado()
  {
    return $this->idAprendizajeEsperado;
  }
  public function getidDiagnostico()
  {
    return $this->idDiagnostico;
  }
  public function getinicio()
  {
    return $this->inicio;
  }
  public function getdesarrollo()
  {
    return $this->desarrollo;
  }
  public function getcierre()
  {
    return $this->cierre;
  }
  public function getrecursos()
  {
    return $this->recursos;
  }
  public function getevaluacion()
  {
    return $this->evaluacion;
  }
  public function getfechaModificacion()
  {
    return $this->fechaModificacion;
  }
  public function getestatus()
  {
    return $this->estatus;
  }
}
