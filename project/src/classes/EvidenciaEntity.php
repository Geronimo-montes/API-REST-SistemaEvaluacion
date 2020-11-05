<?php 
    class EvidenciaEntity{
        protected $idEvidencia;
        protected $idPlanTrabajo;
        protected $nombreEvidencia;
        protected $descripcion;
        protected $formatoEsperado;
        protected $evidenciaOpcional;

        public function __construct(array $data){
            isset($data['idEvidencia']) ? $this->idEvidencia = $data['idEvidencia'] : $this->idEvidencia = NULL;
            isset($data['idPlanTrabajo']) ? $this->idPlanTrabajo = $data['idPlanTrabajo'] : $this->idPlanTrabajo = NULL;
            isset($data['nombreEvidencia']) ? $this->nombreEvidencia = $data['nombreEvidencia'] : $this->nombreEvidencia = NULL;
            isset($data['descripcion']) ? $this->descripcion = $data['descripcion'] : $this->descripcion = NULL;
            isset($data['formatoEsperado']) ? $this->formatoEsperado = $data['formatoEsperado'] : $this->formatoEsperado = NULL;
            isset($data['evidenciaOpcional']) ? $this->evidenciaOpcional = $data['evidenciaOpcional'] : $this->evidenciaOpcional = NULL;            
        }

        public function getidEvidencia() { return $this->idEvidencia; }
        public function getidPlanTrabajo() { return $this->idPlanTrabajo; }
        public function getnombreEvidencia() { return $this->nombreEvidencia; }
        public function getdescripcion() { return $this->descripcion; }
        public function getformatoEsperado() { return $this->formatoEsperado; }
        public function getevidenciaOpcional() { return $this->evidenciaOpcional; }        
    }
?>