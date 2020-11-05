<?php 
    class CuadorHonorEntity{
        protected $idCuadroHonor;
        protected $idAlumno;
        protected $idActividadProgramada;
        
        public function __construct(array $data){
            (isset($data['idCuadroHonor'])) ? $this->idCuadroHonor = $data['idCuadroHonor'] : $this->idCuadroHonor = NULL;
            (isset($data['idAlumno'])) ? $this->idAlumno = $data['idAlumno'] : $this->idAlumno = NULL;
            (isset($data['idActividadProgramada'])) ? $this->idActividadProgramada = $data['idActividadProgramada'] : $this->idActividadProgramada = NULL;
        }

        public function getidCuadroHonor() { return $this->$idCuadroHonor; }
        public function getidAlumno() { return $this->$idAlumno; }
        public function getidActividadProgramada() { return $this->$idActividadProgramada; }        
    }
?>