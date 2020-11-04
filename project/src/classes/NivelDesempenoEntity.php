<?php 
    class NivelDesempenoEntity{
        protected $idNivelDesempeno;
        protected $nombre;
        protected $abreviacion;
        protected $valorNumerico;

        public function __construct(array $data){
            (isset($data['idNivelDesempeno'])) ? $this->idNivelDesempeno = $data['idNivelDesempeno'] : $this->idNivelDesempeno = NULL;
            (isset($data['nombre']))           ? $this->nombre = $data['nombre']                     : $this->nombre = NULL;
            (isset($data['abreviacion']))      ? $this->abreviacion = $data['abreviacion']           : $this->abreviacion = NULL;
            (isset($data['valorNumerico']))    ? $this->valorNumerico = $data['valorNumerico']       : $this->valorNumerico = NULL;
        }
        public function getidNivelDesempeno(){ return $this->idNivelDesempeno; }
        public function getnombre()          { return $this->nombre; }
        public function getabreviacion()     { return $this->abreviacion; }
        public function getvalorNumerico()   { return $this->valorNumerico; }
    }
?>