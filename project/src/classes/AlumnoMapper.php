<?php
class AlumnoMapper extends Mapper
{
  private function generarArray($data)
  {
    $array = [];
    foreach ($data as $alumno) {
      array_push($array, array(
        "idAlumno"              => $alumno->getidAlumno(),
        "idEscuela"             => $alumno->getidEscuela(),
        "nombre"                => $alumno->getnombre(),
        "ap1"                   => $alumno->getap1(),
        "ap2"                   => $alumno->getap2(),
        "curp"                  => $alumno->getcurp(),
        "grupo"                 => $alumno->getgrupo(),
        "grado"                 => $alumno->getgrado(),
        "turno"                 => $alumno->getturno(),
        "nombreTutor"           => $alumno->getnombreTutor(),
        "direccion"             => $alumno->getdireccion(),
        "telefono"              => $alumno->gettelefono(),
        "email"                 => $alumno->getemail(),
        "facebook"              => $alumno->getfacebook(),
        "preferennciaContacto"  => $alumno->getpreferennciaContacto(),
        "estatus"               => $alumno->getestatus(),
        "rutaExpediente"        => $alumno->getrutaExpediente(),
        "rutaPerfil"            => $alumno->getrutaPerfil()
      ));
    }
    return $array;
  }

  public function getAlumnos($grupo, $grado, $turno)
  {
    $sql = "SELECT  * FROM alumno WHERE estatus = 'a' AND grupo = :grupo AND grado = :grado AND turno = :turno";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(":grupo",      $grupo, PDO::PARAM_STR, 1);
    $stmt->bindParam(":grado",      $grado, PDO::PARAM_STR, 1);
    $stmt->bindParam(":turno",      $turno, PDO::PARAM_STR, 1);

    $results = [];
    if ($stmt->execute()) {
      while ($row = $stmt->fetch()) {
        $results[] = new AlumnoEntity($row);
      }
    }
    return $this->generarArray($results);
  }

  public function getAlumnoById($id)
  {
    $sql = "SELECT * FROM alumno WHERE idAlumno = :idAlumno AND estatus = 'a'";

    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(":idAlumno", $id, PDO::PARAM_STR, 50);

    if ($stmt->execute()) {
      $results = [];
      while ($row = $stmt->fetch()) {
        $results[] = new AlumnoEntity($row);
      }
      return (sizeof($this->generarArray($results)) > 1) ?
        $this->generarArray($results)[0] :
        $this->generarArray($results);
    }
  }

  public function UpdateAlumnoById(AlumnoEntity $alumno)
  {
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
      facebook = :facebook
      WHERE idAlumno = :idAlumno";

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

    if ($stmt->execute()) {
      return $this->getAlumnoById($alumno->getidAlumno());
    }
  }

  public function InsertAlumno(AlumnoEntity $alumno)
  {
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
      'a',
      :rutaExpediente
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
    $rutaExpediente         = $alumno->getrutaExpediente() . "/" . $idAlumno;

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
    $stmt->bindParam(":rutaExpediente", $rutaExpediente, PDO::PARAM_STR, 200);

    if ($stmt->execute()) {
      if (mkdir($rutaExpediente))
        return "exito en la insercion";
    }
  }
}
