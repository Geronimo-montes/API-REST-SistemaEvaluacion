<?php 
    class DocenteEntity
    {
        protected $idDocente;
        protected $nombreEscuela;
        protected $nombre;
        protected $ap1;
        protected $ap2;
        protected $curp;
        protected $rfc;
        protected $direccion;
        protected $telefono;
        protected $email;
        protected $facebook;
        protected $grupo;
        protected $grado;
        protected $turno;
        protected $rol;
        protected $estatus;

        public function __construct(array $data){
            if(isset($data['idDocente'])){
                $this->idDocente = $data['idDocente'];
                $this->nombreEscuela = $data['nombreEscuela'];
                $this->nombre = $data['nombre'];
                $this->ap1 = $data['ap1'];
                $this->ap2 = $data['ap2'];
                $this->curp = $data['curp'];
                $this->rfc = $data['rfc'];
                $this->direccion = $data['direccion'];
                $this->telefono = $data['telefono'];
                $this->email = $data['email'];
                $this->facebook = $data['facebook'];
                $this->grupo = $data['grupo'];
                $this->grado = $data['grado'];
                $this->turno = $data['turno'];
                $this->rol = $data['rol'];
                $this->estatus = $data['estatus'];
            }else{
                $this->idDocente =NULL;
                $this->nombreEscuela =NULL;
                $this->nombre =NULL;
                $this->ap1 =NULL;
                $this->ap2 =NULL;
                $this->curp =NULL;
                $this->rfc =NULL;
                $this->direccion =NULL;
                $this->telefono =NULL;
                $this->email =NULL;
                $this->facebook =NULL;
                $this->grupo =NULL;
                $this->grado =NULL;
                $this->turno =NULL;
                $this->rol =NULL;
                $this->estatus =NULL;
            }
        }

        public function  getidDocente()     { return $this->idDocente;      }
        public function  getnombreEscuela() { return $this->nombreEscuela;  }
        public function  getnombre()        { return $this->nombre;         }
        public function  getap1()           { return $this->ap1;            }
        public function  getap2()           { return $this->ap2;            }
        public function  getcurp()          { return $this->curp;           }
        public function  getrfc()           { return $this->rfc;            }
        public function  getdireccion()     { return $this->direccion;      }
        public function  gettelefono()      { return $this->telefono;       }
        public function  getemail()         { return $this->email;          }
        public function  getfacebook()      { return $this->facebook;       }
        public function  getgrupo()         { return $this->grupo;          }
        public function  getgrado()         { return $this->grado;          }
        public function  getturno()         { return $this->turno;          }
        public function  getrol()           { return $this->rol;            }
        public function  getestatus()       { return $this->estatus;        }
    }
?>