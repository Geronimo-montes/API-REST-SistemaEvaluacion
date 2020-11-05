<?php 
    class CicloEscolarEntity {
        protected $idCicloEscolar;
        protected $inicioCiclo;
        protected $finCiclo;
        protected $diasHabiles;
        protected $estatus;
        
        public function __construct(array $data){
            (isset($data{'idCicloEscolar'})) ? $this->idCicloEscolar = $data['idCicloEscolar'] : $this->idCicloEscolar = NULL;
            (isset($data{'inicioCiclo'})) ? $this->inicioCiclo = $data['inicioCiclo'] : $this->inicioCiclo = NULL;
            (isset($data{'finCiclo'})) ? $this->finCiclo = $data['finCiclo'] : $this->finCiclo = NULL;
            (isset($data{'diasHabiles'})) ? $this->diasHabiles = $data['diasHabiles'] : $this->diasHabiles = NULL;
            (isset($data{'estatus'})) ? $this->estatus = $data['estatus'] : $this->estatus = NULL;            
        }

        public function getidCicloEscolar() { return $this->idCicloEscolar; }
        public function getinicioCiclo() { return $this->inicioCiclo; }
        public function getfinCiclo() { return $this->finCiclo; }
        public function getdiasHabiles() { return $this->diasHabiles; }
        public function getestatus() { return $this->estatus; }        
    }
?>