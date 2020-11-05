<?php 
    class AlumnoEntity{
        
        protected $idAlumno;
        protected $idEscuela;
        protected $nombre;
        protected $ap1;
        protected $ap2;
        protected $curp;
        protected $grupo;
        protected $grado;
        protected $turno;
        protected $nombreTutor;
        protected $direccion;
        protected $telefono;
        protected $email;
        protected $facebook;
        protected $preferennciaContacto;
        protected $estatus;

        public function __construct (array $data){
            (isset($data['idAlumno'])) ?  $this->idAlumno = $data['idAlumno'] : $this->idAlumno = NULL;
            (isset($data['idEscuela'])) ?  $this->idEscuela = $data['idEscuela'] : $this->idEscuela = NULL;
            (isset($data['nombre'])) ?  $this->nombre = $data['nombre'] : $this->nombre = NULL;
            (isset($data['ap1'])) ?  $this->ap1 = $data['ap1'] : $this->ap1 = NULL;
            (isset($data['ap2'])) ?  $this->ap2 = $data['ap2'] : $this->ap2 = NULL;
            (isset($data['curp'])) ?  $this->curp = $data['curp'] : $this->curp = NULL;
            (isset($data['grupo'])) ?  $this->grupo = $data['grupo'] : $this->grupo = NULL;
            (isset($data['grado'])) ?  $this->grado = $data['grado'] : $this->grado = NULL;
            (isset($data['turno'])) ?  $this->turno = $data['turno'] : $this->turno = NULL;
            (isset($data['nombreTutor'])) ?  $this->nombreTutor = $data['nombreTutor'] : $this->nombreTutor = NULL;
            (isset($data['direccion'])) ?  $this->direccion = $data['direccion'] : $this->direccion = NULL;
            (isset($data['telefono'])) ?  $this->telefono = $data['telefono'] : $this->telefono = NULL;
            (isset($data['email'])) ?  $this->email = $data['email'] : $this->email = NULL;
            (isset($data['facebook'])) ?  $this->facebook = $data['facebook'] : $this->facebook = NULL;
            (isset($data['preferennciaContacto'])) ?  $this->preferennciaContacto = $data['preferennciaContacto'] : $this->preferennciaContacto = NULL;
            (isset($data['estatus'])) ?  $this->estatus = $data['estatus'] : $this->estatus = NULL;
        }

        public function getidAlumno(){ return $this->idAlumno; }
        public function getidEscuela(){ return $this->idEscuela; }
        public function getnombre(){ return $this->nombre; }
        public function getap1(){ return $this->ap1; }
        public function getap2(){ return $this->ap2; }
        public function getcurp(){ return $this->curp; }
        public function getgrupo(){ return $this->grupo; }
        public function getgrado(){ return $this->grado; }
        public function getturno(){ return $this->turno; }
        public function getnombreTutor(){ return $this->nombreTutor; }
        public function getdireccion(){ return $this->direccion; }
        public function gettelefono(){ return $this->telefono; }
        public function getemail(){ return $this->email; }
        public function getfacebook(){ return $this->facebook; }
        public function getpreferennciaContacto(){ return $this->preferennciaContacto; }
        public function getestatus(){ return $this->estatus; }
    }
?>