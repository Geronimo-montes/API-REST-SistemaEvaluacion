<?php 
    class ActividadAlumnoEntity{
        protected $idActividadProgramada;
        protected $idAlumno;
        protected $idNivelDesempeno;
        protected $observacion;
        protected $rutaEvidencia;
        
        public function __construct(array $data){
            (isset($data['idActividadProgramada'])) ? $this->idActividadProgramada = $data['idActividadProgramada'] : $this->idActividadProgramada = NULL; 
            (isset($data['idAlumno']))              ? $this->idAlumno = $data['idAlumno']                           : $this->idAlumno = NULL; 
            (isset($data['idNivelDesempeno']))      ? $this->idNivelDesempeno = $data['idNivelDesempeno']           : $this->idNivelDesempeno = NULL; 
            (isset($data['observacion']))           ? $this->observacion = $data['observacion']                     : $this->observacion = NULL; 
            (isset($data['rutaEvidencia']))         ? $this->rutaEvidencia = $data['rutaEvidencia']                 : $this->rutaEvidencia = NULL;             
        }

        public function getidActividadProgramada() { return $this->idActividadProgramada; }
        public function getidAlumno()              { return $this->idAlumno; }
        public function getidNivelDesempeno()      { return $this->idNivelDesempeno; }
        public function getobservacion()           { return $this->observacion; }
        public function getrutaEvidencia()         { return $this->rutaEvidencia; }        
    }
?>