<?php 
    class EscuelaEntity{
        protected $idEscuela;
        protected $nombre;
        protected $clave;
        protected $zonaEscolar;
        protected $sector;
        protected $direccion;
        protected $telefono;

        public function __construct(array $data){
            (isset($data['idEscuela'])) ?  $this->idEscuela = $data['idEscuela'] : $this->idEscuela = NULL;
            (isset($data['nombre'])) ?  $this->nombre = $data['nombre'] : $this->nombre = NULL;
            (isset($data['clave'])) ?  $this->clave = $data['clave'] : $this->clave = NULL;
            (isset($data['zonaEscolar'])) ?  $this->zonaEscolar = $data['zonaEscolar'] : $this->zonaEscolar = NULL;
            (isset($data['sector'])) ?  $this->sector = $data['sector'] : $this->sector = NULL;
            (isset($data['direccion'])) ?  $this->direccion = $data['direccion'] : $this->direccion = NULL;
            (isset($data['telefono'])) ?  $this->telefono = $data['telefono'] : $this->telefono = NULL;            
        }
        
        public function getidEscuela(){ return $this->idEscuela; }
        public function getnombre(){ return $this->nombre; }
        public function getclave(){ return $this->clave; }
        public function getzonaEscolar(){ return $this->zonaEscolar; }
        public function getsector(){ return $this->sector; }
        public function getdireccion(){ return $this->direccion; }
        public function gettelefono(){ return $this->telefono; }        
    }
?>