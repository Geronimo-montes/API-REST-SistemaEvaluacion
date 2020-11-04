<?php 
    class AreaFormacionEntity{
        protected $idAreaFormacion;
        protected $descripcion;
        protected $estatus;

        public function __construct(array $data){
            (isset($data['idAreaFormacion'])) ? $this->idAreaFormacion = $data['idAreaFormacion'] : $this->idAreaFormacion = NULL;
            (isset($data['descripcion']))     ? $this->descripcion = $data['descripcion']         : $this->descripcion = NULL;
            (isset($data['estatus']))         ? $this->estatus = $data['estatus']                 : $this->estatus = NULL;            
        }
        
        public function getidAreaFormacion(){ return $this->idAreaFormacion; }
        public function getdescripcion()    { return $this->descripcion; }
        public function getestatus()        { return $this->estatus; }        
    }
?>