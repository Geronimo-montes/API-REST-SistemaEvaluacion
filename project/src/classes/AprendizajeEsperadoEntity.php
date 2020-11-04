<?php 
    class AprendizajeEsperadoEntity{
        protected $idAprendizajeEsperado;
        protected $idAreaFormacion;
        protected $descripcion;
        protected $estatus;
        
        public function __construct(array $data){
            (isset($data['idAprendizajeEsperado'])) ? $this->idAprendizajeEsperado = $data['idAprendizajeEsperado'] : $this->idAprendizajeEsperado = NULL;
            (isset($data['idAreaFormacion']))       ? $this->idAreaFormacion = $data['idAreaFormacion']             : $this->idAreaFormacion = NULL;
            (isset($data['descripcion']))           ? $this->descripcion = $data['descripcion']                     : $this->descripcion = NULL;
            (isset($data['estatus']))               ? $this->estatus = $data['estatus']                             : $this->estatus = NULL;            
        }

        public function getidAprendizajeEsperado() { return $this->idAprendizajeEsperado; }
        public function getidAreaFormacion()       { return $this->idAreaFormacion; }
        public function getdescripcion()           { return $this->descripcion; }
        public function getestatus()               { return $this->estatus; }        
    }
?>