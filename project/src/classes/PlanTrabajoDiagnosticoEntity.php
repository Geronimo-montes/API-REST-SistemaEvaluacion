<?php 
    class PlanTrabajoDiagnosticoEntity{
        protected $idDiagnostico;
        protected $idPlanTrabajo;
        
        public function __construct(array $data){
            (isset($data['idDiagnostico'])) ? $this->idDiagnostico = $data['idDiagnostico'] : $this->idDiagnostico = NULL;
            (isset($data['idPlanTrabajo'])) ? $this->idPlanTrabajo = $data['idPlanTrabajo'] : $this->idPlanTrabajo = NULL;            
        }
  
        public function getidDiagnostico() { return $this->idDiagnostico; }
        public function getidPlanTrabajo() { return $this->idPlanTrabajo; }        
    }
?>