<?php
class EvidenciaEntity
{
  protected $idEvidencia;
  protected $idPlanTrabajo;
  protected $nombreEvidencia;
  protected $descripcion;
  protected $idFormato;

  public function __construct(array $data)
  {
    isset($data['idEvidencia']) ? $this->idEvidencia = $data['idEvidencia'] : $this->idEvidencia = NULL;
    isset($data['idPlanTrabajo']) ? $this->idPlanTrabajo = $data['idPlanTrabajo'] : $this->idPlanTrabajo = NULL;
    isset($data['nombreEvidencia']) ? $this->nombreEvidencia = $data['nombreEvidencia'] : $this->nombreEvidencia = NULL;
    isset($data['descripcion']) ? $this->descripcion = $data['descripcion'] : $this->descripcion = NULL;
    isset($data['idFormato']) ? $this->idFormato = $data['idFormato'] : $this->idFormato = NULL;
  }

  public function getidEvidencia()
  {
    return $this->idEvidencia;
  }
  public function getidPlanTrabajo()
  {
    return $this->idPlanTrabajo;
  }
  public function getnombreEvidencia()
  {
    return $this->nombreEvidencia;
  }
  public function getdescripcion()
  {
    return $this->descripcion;
  }
  public function getidFormato()
  {
    return $this->idFormato;
  }
}
