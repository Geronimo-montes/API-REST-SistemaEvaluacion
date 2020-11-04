<?php
    class DocenteMapper extends Mapper
    {
        public function getDocentes(){
        /**************************************************************************
        * Parametros:	
        * Proposito:	listar informacion de los docentes
        * Return:		array
        **************************************************************************/
            $sql = "SELECT d.idDocente, 
                           e.nombre as nombreEscuela, 
                           d.nombre, 
                           d.ap1, 
                           d.ap2,  
                           d.curp, 
                           d.rfc, 
                           d.direccion, 
                           d.telefono, 
                           d.email, 
                           d.facebook, 
                           d.grupo, 
                           d.grado, 
                           d.turno, 
                           d.rol, 
                           d.estatus
                    FROM docente d
                    JOIN escuela e ON d.idEscuela = e.idEscuela
                    WHERE estatus = 'a'";

            $stmt = $this->db->query($sql);

            $results = [];
            while ($row = $stmt->fetch()){
                $results[] = new DocenteEntity($row);
            }

            return $results;
        }

        public function getDocenteById($id){
        /**************************************************************************
        * Parametros:	$id -> id del docente a consultar
        * Proposito:	consultar infpracion docente su informacion
        * Return:		array
        **************************************************************************/
            $sql = "SELECT d.idDocente, 
                           e.nombre as nombreEscuela, 
                           d.nombre, 
                           d.ap1, 
                           d.ap2,  
                           d.curp, 
                           d.rfc, 
                           d.direccion, 
                           d.telefono, 
                           d.email, 
                           d.facebook, 
                           d.grupo, 
                           d.grado, 
                           d.turno, 
                           d.rol, 
                           d.estatus
                    FROM docente d
                    JOIN escuela e ON d.idEscuela = e.idEscuela
                    WHERE estatus = 'a' AND d.idDocente = :idDocente";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":idDocente", $id, PDO::PARAM_INT);

            if($stmt->execute()){
                $results = [];
                $results = $stmt->fetch();
                
                if(!empty($results))
                    return new DocenteEntity($results);
            }
        }

        public  function updateDocenteById (DocenteEntity $docente){
        /**************************************************************************
        * Parametros:	@DocenteEntity $docente -> tipo de dato coerrespodiente a los datos de un maestos
        * Proposito:	actualizar su informacion
        * Return:		true / flase
        **************************************************************************/
            $sql = "UPDATE docente SET 
                    nombre = :nombre, 
                    ap1 = :ap1, 
                    ap2 = :ap2, 
                    curp = :curp, 
                    rfc = :rfc, 
                    direccion = :direccion, 
                    telefono = :telefono, 
                    email = :email, 
                    facebook = :facebook, 
                    grupo = :grupo, 
                    grado = :grado, 
                    turno = :turno, 
                    rol = :rol, 
                    estatus = :estatus 
                    WHERE idDocente = :idDocente";

            $stmt = $this->db->prepare($sql);

            /**Para evitar que se produzca un error es necesario a la hora de bindear el parametro
             * es necesario alacenarlos en una bariable dado que no es pocible hacerlo detro del metodo
             * bindParam.
             */

            $nombre     = $docente->getnombre();
            $ap1        = $docente->getap1();
            $ap2        = $docente->getap2();
            $curp       = $docente->getcurp();
            $rfc        = $docente->getrfc();
            $direccion  = $docente->getdireccion();
            $telefono   = $docente->gettelefono();
            $email      = $docente->getemail();
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
            $stmt->bindParam(":email",      $email, PDO::PARAM_STR, 80);
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
    }
?>  