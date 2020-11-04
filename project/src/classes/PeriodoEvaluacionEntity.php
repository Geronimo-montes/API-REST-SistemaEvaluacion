<?php 
    class PeriodoEvaluacionEntity{
        protected $idPeriodoEvaluacion;
        protected $nombre;
        protected $numeroEvaluacion;
        protected $mesInicio;
        protected $mesFinal;
        protected $estatus;

        public function __construct(array $data){
            (isset($data['idPeriodoEvaluacion'])) ? $this->idPeriodoEvaluacion = $data['idPeriodoEvaluacion'] : $this->idPeriodoEvaluacion = NULL;
            (isset($data['nombre']))              ? $this->nombre = $data['nombre']                           : $this->nombre = NULL;
            (isset($data['numeroEvaluacion']))    ? $this->numeroEvaluacion = $data['numeroEvaluacion']       : $this->numeroEvaluacion = NULL;
            (isset($data['mesInicio']))           ? $this->mesInicio = $data['mesInicio']                     : $this->mesInicio = NULL;
            (isset($data['mesFinal']))            ? $this->mesFinal = $data['mesFinal']                       : $this->mesFinal = NULL;
            (isset($data['estatus']))             ? $this->estatus = $data['estatus']                         : $this->estatus = NULL;
        }

        public function getidPeriodoEvaluacion() { return $this->idPeriodoEvaluacion; }
        public function getnombre()              { return $this->nombre; }
        public function getnumeroEvaluacion()    { return $this->numeroEvaluacion; }
        public function getmesInicio()           { return $this->mesInicio; }
        public function getmesFinal()            { return $this->mesFinal; }
        public function getestatus()             { return $this->estatus; }
    }
?>