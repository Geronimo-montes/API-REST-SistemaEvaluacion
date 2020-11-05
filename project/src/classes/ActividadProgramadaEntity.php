<?php 
    class ActividadProgramadaEntity{
        protected $idActividadProgramada;
        protected $idPlanTrabajo;
        protected $idNivelDesempeno;
        protected $idPeriodoEvaluacion;
        protected $idCicloEscolar;
        protected $nivelDesempenoPonderado;
        protected $observacion;
        protected $fecha;
        protected $estatus; //a:activa t:terminada e:empezada b:baja/canceladax

        public function __construct(array $data){
            (isset($data['idActividadProgramada']))   ? $this->idActividadProgramada = $data['idActividadProgramada']     : $this->idActividadProgramada = NULL;
            (isset($data['idPlanTrabajo']))           ? $this->idPlanTrabajo = $data['idPlanTrabajo']                     : $this->idPlanTrabajo = NULL;
            (isset($data['idNivelDesempeno']))        ? $this->idNivelDesempeno = $data['idNivelDesempeno']               : $this->idNivelDesempeno = NULL;
            (isset($data['idPeriodoEvaluacion']))     ? $this->idPeriodoEvaluacion = $data['idPeriodoEvaluacion']         : $this->idPeriodoEvaluacion = NULL;
            (isset($data['idCicloEscolar']))          ? $this->idCicloEscolar = $data['idCicloEscolar']                   : $this->idCicloEscolar = NULL;
            (isset($data['nivelDesempenoPonderado'])) ? $this->nivelDesempenoPonderado = $data['nivelDesempenoPonderado'] : $this->nivelDesempenoPonderado = NULL;
            (isset($data['observacion']))             ? $this->observacion = $data['observacion']                         : $this->observacion = NULL;
            (isset($data['fecha']))                   ? $this->fecha = $data['fecha']                                     : $this->fecha = NULL;
            (isset($data['estatus']))                 ? $this->estatus = $data['estatus']                                 : $this->estatus = NULL;            
        }
        
        public function getidActividadProgramada()   { return $this->idActividadProgramada; }
        public function getidPlanTrabajo()           { return $this->idPlanTrabajo; }
        public function getidNivelDesempeno()        { return $this->idNivelDesempeno; }
        public function getidPeriodoEvaluacion()     { return $this->idPeriodoEvaluacion; }
        public function getidCicloEscolar()         { return $this->idCicloEscolar; }
        public function getnivelDesempenoPonderado() { return $this->nivelDesempenoPonderado; }
        public function getobservacion()             { return $this->observacion; }
        public function getfecha()                   { return $this->fecha; }
        public function getestatus()                 { return $this->estatus; }        
    }
?>