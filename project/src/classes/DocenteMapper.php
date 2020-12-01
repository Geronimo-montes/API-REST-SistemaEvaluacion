<?php
    class DocenteMapper extends Mapper{
        private function generarArray ($data){
            $array = [];
            foreach ($data as $docente) {
                array_push($array, array(
                    "idDocente"     => $docente->getidDocente(),
                    "idEscuela"     => $docente->getidEscuela(),
                    "nombre"        => $docente->getnombre(),
                    "ap1"           => $docente->getap1(),
                    "ap2"           => $docente->getap2(),
                    "curp"          => $docente->getcurp(),
                    "rfc"           => $docente->getrfc(),
                    "direccion"     => $docente->getdireccion(),
                    "telefono"      => $docente->gettelefono(),
                    "email"         => $docente->getemail(),
                    "facebook"      => $docente->getfacebook(),
                    "grupo"         => $docente->getgrupo(),
                    "grado"         => $docente->getgrado(),
                    "turno"         => $docente->getturno(),
                    "rol"           => $docente->getrol(),
                    "estatus"       => $docente->getestatus()
                ));
            }
            return $array;
        }

        public function getDocentes(){
            $sql = "SELECT * FROM docente WHERE estatus = 'a'";
            $stmt = $this->db->query($sql);
            $results = [];
            while ($row = $stmt->fetch()){
                $results[] = new DocenteEntity($row);
            }

            return $this->generarArray( $results );
        }

        public function getDocenteById($id){
            $sql = "SELECT * FROM docente WHERE estatus = 'a' AND idDocente = :idDocente";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":idDocente", $id, PDO::PARAM_INT);

            if($stmt->execute()){
                $results = [];
                while ($row = $stmt->fetch()){
                    $results[] = new DocenteEntity($row);
                }
    
                return $this->generarArray( $results );
            }
        }

        public  function updateDocenteById (DocenteEntity $docente){
            $sql = "UPDATE docente SET 
                    nombre = :nombre, 
                    ap1 = :ap1, 
                    ap2 = :ap2, 
                    curp = :curp, 
                    rfc = :rfc, 
                    direccion = :direccion, 
                    telefono = :telefono, 
                    facebook = :facebook, 
                    grupo = :grupo, 
                    grado = :grado, 
                    turno = :turno, 
                    rol = :rol, 
                    estatus = :estatus 
                    WHERE idDocente = :idDocente";

            $stmt = $this->db->prepare($sql);

            $nombre     = $docente->getnombre();
            $ap1        = $docente->getap1();
            $ap2        = $docente->getap2();
            $curp       = $docente->getcurp();
            $rfc        = $docente->getrfc();
            $direccion  = $docente->getdireccion();
            $telefono   = $docente->gettelefono();
            $facebook   = $docente->getfacebook();
            $grupo      = $docente->getgrupo();
            $grado      = $docente->getgrado();
            $turno      = $docente->getturno();
            $rol        = $docente->getrol();
            $estatus    = $docente->getestatus();
            $idDocente  = $docente->getidDocente();

            $stmt->bindParam(":nombre",     $nombre, PDO::PARAM_STR, 50);
            $stmt->bindParam(":ap1",        $ap1, PDO::PARAM_STR, 50);
            $stmt->bindParam(":ap2",        $ap2, PDO::PARAM_STR, 50);
            $stmt->bindParam(":curp",       $curp, PDO::PARAM_STR, 18);
            $stmt->bindParam(":rfc",        $rfc, PDO::PARAM_STR, 13);
            $stmt->bindParam(":direccion",  $direccion, PDO::PARAM_STR, 100);
            $stmt->bindParam(":telefono",   $telefono, PDO::PARAM_STR, 10);
            $stmt->bindParam(":facebook",   $facebook, PDO::PARAM_STR, 50);
            $stmt->bindParam(":grupo",      $grupo, PDO::PARAM_STR, 1);
            $stmt->bindParam(":grado",      $grado, PDO::PARAM_STR, 1);
            $stmt->bindParam(":turno",      $turno, PDO::PARAM_STR, 1);
            $stmt->bindParam(":rol",        $rol, PDO::PARAM_STR, 50);
            $stmt->bindParam(":estatus",    $estatus, PDO::PARAM_STR, 1);
            $stmt->bindParam(":idDocente",  $idDocente, PDO::PARAM_INT);

            if($stmt->execute()){
                return $this->getDocenteById($docente->getidDocente());
            }
        }

        /**Funciones referetes a los usuarios*/
        public function logIn($data) {/** */
            $sql = "SELECT idDocente FROM docente WHERE email = :email AND contraseña = :password";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":email", $data['email'], PDO::PARAM_STR, 80);
            $stmt->bindParam(":password", $data['password'], PDO::PARAM_STR, 20);
            $results = NULL;            
            if($stmt->execute())
                while ($row = $stmt->fetch())
                    $results = $row['idDocente'];

            return $results;
        }

        public  function updateUserById ($data){
            $sql = "UPDATE docente SET 
                    email = :email,
                    contraseña = :password 
                    WHERE idDocente = :idDocente";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":email", $data['email'], PDO::PARAM_STR, 80);
            $stmt->bindParam(":password", $data['password'], PDO::PARAM_STR, 20);
            $stmt->bindParam(":idDocente",  $data['idDocente'], PDO::PARAM_INT);
            $res = false;

            if($stmt->execute())
                if($stmt->rowCount() > 0)
                    $res = !$res;
            
            return $res;
        }

        public function logOut($data) {
            $sql = "UPDATE docente SET 
                    token = :token
                    WHERE idDocente = :idDocente";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":token", NULL, PDO::PARAM_NULL);
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function insertToken($data) {/** */
            $sql = "UPDATE docente SET 
                    token = :token
                    WHERE idDocente = :idDocente";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":token",      $data['token'], PDO::PARAM_STR, 215);
            $stmt->bindParam(":idDocente",  $data['id'],    PDO::PARAM_INT);

            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function validarToken($data) {
            $sql = "SELECT idDocente FROM docente WHERE token = :token";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":token", $data, PDO::PARAM_STR, 215);
            if($stmt->execute())
                if($stmt->rowCount() > 0){
                    while ($row = $stmt->fetch())
                      $id = $row['idDocente'];
                    return ['success' => true, 'id' => $id];
                }else
                    return ['success' => false, 'mensaje' => 'Token no valido'];


            return $res;
        }
    }
?>  