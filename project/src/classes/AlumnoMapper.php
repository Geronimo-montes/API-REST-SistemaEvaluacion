<?php 
    class AlumnoMapper extends Mapper{
        public function getAlumnos ($grupo, $grado, $turno){
        /**************************************************************************
        * Parametros:	turno, grado y grupo
        * Proposito:	Listar alumnos de un grupo en especifico con relacion a grado, grupo y turno
        * Return:		array
        **************************************************************************/
            $sql = "SELECT  a.idAlumno,
                            e.nombre as nombreEscuela,
                            a.nombre,
                            a.ap1,
                            a.ap2,
                            a.curp,
                            a.grupo,
                            a.grado,
                            a.turno,
                            a.nombreTutor,
                            a.direccion,
                            a.telefono,
                            a.email,
                            a.facebook,
                            a.preferennciaContacto,
                            a.estatus
                    FROM alumno a
                    JOIN escuela e ON a.idEscuela = e.idEscuela
                    WHERE a.estatus = 'a' AND a.grupo = :grupo AND a.grado = :grado AND a.turno = :turno"
            ;


            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":grupo",      $grupo, PDO::PARAM_STR, 1);
            $stmt->bindParam(":grado",      $grado, PDO::PARAM_STR, 1);
            $stmt->bindParam(":turno",      $turno, PDO::PARAM_STR, 1);

            $results = [];

            if($stmt->execute()){
                while ($row = $stmt->fetch()){
                    $results[] = new AlumnoEntity($row);
                }
            }

            return $results;
        } 

        public function getAlumnoById ($id){
        /**************************************************************************
        * Parametros:	
        * Proposito:	
        * Return:		array
        **************************************************************************/
            $sql = "SELECT  
                    a.idAlumno,
                    e.nombre as nombreEscuela,
                    a.nombre,
                    a.ap1,
                    a.ap2,
                    a.curp,
                    a.grupo,
                    a.grado,
                    a.turno,
                    a.nombreTutor,
                    a.direccion,
                    a.telefono,
                    a.email,
                    a.facebook,
                    a.preferennciaContacto,
                    a.estatus
                    FROM alumno a
                    JOIN escuela e ON a.idEscuela = e.idEscuela
                    WHERE a.idAlumno = :idAlumno AND a.estatus = 'a'"
            ;

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":idAlumno", $id, PDO::PARAM_INT);

            if($stmt->execute()){
                $results = [];
                $results = $stmt->fetch();
                
                if(!empty($results))
                    return new AlumnoEntity($results);
            }
        }

        public function UpdateAlumnoById (AlumnoEntity $alumno){
        /**************************************************************************
        * Parametros:	
        * Proposito:	
        * Return:		array
        **************************************************************************/
            $sql = "UPDATE alumno SET
                    nombre = :nombre,
                    ap1 = :ap1,
                    ap2 = :ap2,
                    curp = :curp,
                    grupo = :grupo,
                    grado = :grado,
                    turno = :turno,
                    nombreTutor = :nombreTutor,
                    direccion = :direccion,
                    telefono = :telefono,
                    email = :email,
                    facebook = :facebook,
                    preferennciaContacto = :preferennciaContacto,
                    estatus = :estatus
                    WHERE idAlumno = :idAlumno"
            ;
            
            $stmt = $this->db->prepare($sql);

            $idAlumno = $alumno->getidAlumno();
            $nombre = $alumno->getnombre();
            $ap1 = $alumno->getap1();
            $ap2 = $alumno->getap2();
            $curp = $alumno->getcurp();
            $grupo = $alumno->getgrupo();
            $grado = $alumno->getgrado();
            $turno = $alumno->getturno();
            $nombreTutor = $alumno->getnombreTutor();
            $direccion = $alumno->getdireccion();
            $telefono = $alumno->gettelefono();
            $email = $alumno->getemail();
            $facebook = $alumno->getfacebook();
            $preferennciaContacto = $alumno->getpreferennciaContacto();
            $estatus = $alumno->getestatus();
            
            $stmt->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR, 50);
            $stmt->bindParam(":ap1", $ap1, PDO::PARAM_STR, 50);
            $stmt->bindParam(":ap2", $ap2, PDO::PARAM_STR, 50);
            $stmt->bindParam(":curp", $curp, PDO::PARAM_STR, 18);
            $stmt->bindParam(":grupo", $grupo, PDO::PARAM_STR, 1);
            $stmt->bindParam(":grado", $grado, PDO::PARAM_STR, 1);
            $stmt->bindParam(":turno", $turno, PDO::PARAM_STR, 1);
            $stmt->bindParam(":nombreTutor", $nombreTutor, PDO::PARAM_STR, 200);
            $stmt->bindParam(":direccion", $direccion, PDO::PARAM_STR, 100);
            $stmt->bindParam(":telefono", $telefono, PDO::PARAM_STR, 10);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR, 80);
            $stmt->bindParam(":facebook", $facebook, PDO::PARAM_STR, 50);
            $stmt->bindParam(":preferennciaContacto", $preferennciaContacto, PDO::PARAM_STR, 50);
            $stmt->bindParam(":estatus", $estatus, PDO::PARAM_STR, 1);

            if($stmt->execute()){
                return $this->getAlumnoById($alumno->getidAlumno());
            }
        }  
        
        public function InsertAlumno (AlumnoEntity $alumno)
        /**************************************************************************
        * Parametros:	objeto tipo alumno entity
        * Proposito:	insertar nuevo alumno
        * Return:		true / false
        **************************************************************************/{
            $sql = "INSERT INTO alumno VALUES (
                :idAlumno,
                1,
                :nombre,
                :ap1,
                :ap2,
                :curp,
                :grupo,
                :grado,
                :turno,
                :nombreTutor,
                :direccion,
                :telefono,
                :email,
                :facebook,
                :preferennciaContacto,
                'a'
            );";
            
            $stmt = $this->db->prepare($sql);

            $idAlumno               = $alumno->getidAlumno();
            $nombre                 = $alumno->getnombre();
            $ap1                    = $alumno->getap1();
            $ap2                    = $alumno->getap2();
            $curp                   = $alumno->getcurp();
            $grupo                  = $alumno->getgrupo();
            $grado                  = $alumno->getgrado();
            $turno                  = $alumno->getturno();
            $nombreTutor            = $alumno->getnombreTutor();
            $direccion              = $alumno->getdireccion();
            $telefono               = $alumno->gettelefono();
            $email                  = $alumno->getemail();
            $facebook               = $alumno->getfacebook();
            $preferennciaContacto   = $alumno->getpreferennciaContacto();

            $stmt->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR, 50);
            $stmt->bindParam(":ap1", $ap1, PDO::PARAM_STR, 50);
            $stmt->bindParam(":ap2", $ap2, PDO::PARAM_STR, 50);
            $stmt->bindParam(":curp", $curp, PDO::PARAM_STR, 18);
            $stmt->bindParam(":grupo", $grupo, PDO::PARAM_STR, 13);
            $stmt->bindParam(":grado", $grado, PDO::PARAM_STR, 1);
            $stmt->bindParam(":turno", $turno, PDO::PARAM_STR, 1);
            $stmt->bindParam(":nombreTutor", $nombreTutor, PDO::PARAM_STR, 200);
            $stmt->bindParam(":direccion", $direccion, PDO::PARAM_STR, 100);
            $stmt->bindParam(":telefono", $telefono, PDO::PARAM_STR, 10);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR, 80);
            $stmt->bindParam(":facebook", $facebook, PDO::PARAM_STR, 50);
            $stmt->bindParam(":preferennciaContacto", $preferennciaContacto, PDO::PARAM_STR, 50);
    
            if($stmt->execute()){
                return "exito en la insercion";
            }
        }
    }
?>