<?php 
    class AlumnoEntity{
        
        protected $idAlumno;
        protected $nombreEscuela;
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
            if(isset($data['idAlumno'])){
                $this->idAlumno = $data['idAlumno'];
                $this->nombreEscuela = $data['nombreEscuela'];
                $this->nombre = $data['nombre'];
                $this->ap1 = $data['ap1'];
                $this->ap2 = $data['ap2'];
                $this->curp = $data['curp'];
                $this->grupo = $data['grupo'];
                $this->grado = $data['grado'];
                $this->turno = $data['turno'];
                $this->nombreTutor = $data['nombreTutor'];
                $this->direccion = $data['direccion'];
                $this->telefono = $data['telefono'];
                $this->email = $data['email'];
                $this->facebook = $data['facebook'];
                $this->preferennciaContacto = $data['preferennciaContacto'];
                $this->estatus = $data['estatus'];
            }else{
                $this->idAlumno = NULL;
                $this->nombreEscuela = NULL;
                $this->nombre = NULL;
                $this->ap1 = NULL;
                $this->ap2 = NULL;
                $this->curp = NULL;
                $this->grupo = NULL;
                $this->grado = NULL;
                $this->turno = NULL;
                $this->nombreTutor = NULL;
                $this->direccion = NULL;
                $this->telefono = NULL;
                $this->email = NULL;
                $this->facebook = NULL;
                $this->preferennciaContacto = NULL;
                $this->estatus = NULL;
            }
        }

        public function getidAlumno(){ return $this->idAlumno; }
        public function getnombreEscuela(){ return $this->nombreEscuela; }
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