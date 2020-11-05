<?php 
    class EvaluacionEntity{
        protected $idAlumno;
        protected $idAreaFormacion;
        protected $idPeriodoEvaluacion;
        protected $idNivelDesempeno;
        protected $idCicloEscolar;
        protected $observacion;
        protected $estatus; 

        public function __construct(array $data){
            (isset($data['idAlumno']))             ? $this->idAlumno = $data['idAlumno']                       : $this->idAlumno = NULL; 
            (isset($data['idAreaFormacion']))      ? $this->idAreaFormacion = $data['idAreaFormacion']         : $this->idAreaFormacion = NULL; 
            (isset($data['idPeriodoEvaluacion']))  ? $this->idPeriodoEvaluacion = $data['idPeriodoEvaluacion'] : $this->idPeriodoEvaluacion = NULL; 
            (isset($data['idNivelDesempeno']))     ? $this->idNivelDesempeno = $data['idNivelDesempeno']       : $this->idNivelDesempeno = NULL; 
            (isset($data['idCicloEscolar']))       ? $this->idCicloEscolar = $data['idCicloEscolar']           : $this->idCicloEscolar = NULL; 
            (isset($data['observacion']))          ? $this->observacion = $data['observacion']                 : $this->observacion = NULL; 
            (isset($data['estatus']))              ? $this->estatus = $data['estatus']                         : $this->estatus = NULL;             
        }
        
        public function getidAlumno()            { return $this->idAlumno; }
        public function getidAreaFormacion()     { return $this->idAreaFormacion; }
        public function getidPeriodoEvaluacion() { return $this->idPeriodoEvaluacion; }
        public function getidNivelDesempeno()    { return $this->idNivelDesempeno; }
        public function getidCicloEscolar()      { return $this->idCicloEscolar; }
        public function getobservacion()         { return $this->observacion; }
        public function getestatus()             { return $this->estatus; }        
    }
?>